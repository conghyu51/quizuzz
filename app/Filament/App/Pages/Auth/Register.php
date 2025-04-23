<?php

namespace App\Filament\App\Pages\Auth;

use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Events\Auth\Registered;
use Filament\Facades\Filament;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\CanUseDatabaseTransactions;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\SimplePage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/**
 * @property Form $form
 */
class Register extends SimplePage
{
    use CanUseDatabaseTransactions;
    use InteractsWithFormActions;
    use WithRateLimiting;

    protected static string $view = 'filament.app.pages.auth.register';
    protected static ?string $title = 'Đăng ký tài khoản';
    protected ?string $heading = 'Đăng ký tài khoản';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill();
    }

    public function register(): ?RegistrationResponse
    {
        return $this->wrapInDatabaseTransaction(function (): ?RegistrationResponse {
            $data = $this->form->getState();

            try {
                $this->rateLimit(2, 1800);

                $data['last_login_at'] = now();

                $user = User::query()->create($data);
                $this->form->model($user)->saveRelationships();

                event(new Registered($user));

                Filament::auth()->login($user);

                session()->regenerate();

                return app(RegistrationResponse::class);
            } catch (TooManyRequestsException $_) {
                Notification::make()
                    ->title('Đăng ký tài khoản quá nhiều lần')
                    ->body('Vui lòng không tạo tài khoản rác.')
                    ->danger()
                    ->send();

                return null;
            }
        });
    }

    public function form(Form $form): Form
    {
        return $form;
    }

    /**
     * @return array<int | string, string | Form>
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        TextInput::make('username')
                            ->label('Tên đăng nhập')
                            ->autocomplete('false')
                            ->required()
                            ->minLength(6)
                            ->maxLength(64)
                            ->unique('users', 'username')
                            ->alphaDash()
                            ->autofocus()
                            ->validationMessages([
                                'required' => 'Vui lòng nhập tên đăng nhập.',
                                'min' => 'Tên đăng nhập phải có tối thiểu :min ký tự.',
                                'max' => 'Tên đăng nhập không được vượt quá :max ký tự.',
                                'unique' => 'Tên đăng nhập đã được sử dụng.',
                                'alpha_dash' => 'Tên đăng nhập chỉ được chứa các ký tự chữ, số và dấu gạch.',
                            ]),
                        TextInput::make('password')
                            ->label('Mật khẩu')
                            ->password()
                            ->revealable(filament()->arePasswordsRevealable())
                            ->required()
                            ->minLength(6)
                            ->maxLength(128)
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->validationMessages([
                                'required' => 'Vui lòng nhập mật khẩu.',
                                'min' => 'Mật khẩu phải có tối thiểu :min ký tự.',
                                'max' => 'Mật khẩu không được vượt quá :max ký tự.',
                            ]),
                        TextInput::make('passwordConfirmation')
                            ->label('Nhập lại mật khẩu')
                            ->password()
                            ->revealable(filament()->arePasswordsRevealable())
                            ->required()
                            ->dehydrated(false)
                            ->same('password')
                            ->validationMessages([
                                'required' => 'Vui lòng nhập lại mật khẩu',
                                'same' => 'Mật khẩu nhập lại không khớp.',
                            ]),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    public function loginAction(): Action
    {
        return Action::make('login')
            ->link()
            ->label('đăng nhập')
            ->url(filament()->getLoginUrl());
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('register')
                ->label('Đăng ký')
                ->submit('register'),
        ];
    }
}
