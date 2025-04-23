<?php

namespace App\Filament\App\Pages\Auth;

use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Models\Contracts\FilamentUser;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\SimplePage;

/**
 * @property Form $form
 */
class Login extends SimplePage
{
    use InteractsWithFormActions;
    use WithRateLimiting;

    protected static ?string $title = 'Đăng nhập';
    protected ?string $heading = 'Đăng nhập';
    protected static string $view = 'filament.app.pages.auth.login';

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

    /**
     * @throws \Exception
     */
    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5, 120);
        } catch (TooManyRequestsException $_) {
            Notification::make()
                ->title('Đăng nhập thất bại quá nhiều lần')
                ->body('Vui lòng thử lại sau ít phút.')
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        if (!Filament::auth()->attempt([
            'username' => $data['username'],
            'password' => $data['password'],
        ], $data['remember'] ?? false)) {
            Notification::make()
                ->title('Thông tin đăng nhập không hợp lệ')
                ->danger()
                ->send();

            return null;
        }

        /** @var User $user */
        $user = Filament::auth()->user();

        if (
            ($user instanceof FilamentUser) &&
            (!$user->canAccessPanel(Filament::getCurrentPanel()))
        ) {
            Filament::auth()->logout();

            Notification::make()
                ->title('Tài khoản này không khả dụng')
                ->danger()
                ->send();

            return null;
        }

        $user->update([
            'last_login_at' => now(),
        ]);

        session()->regenerate();

        return app(LoginResponse::class);
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
                            ->required()
                            ->autocomplete()
                            ->autofocus()
                            ->extraInputAttributes(['tabindex' => 1]),
                        TextInput::make('password')
                            ->label('Mật khẩu')
                            ->password()
                            ->autocomplete('current-password')
                            ->required()
                            ->extraInputAttributes(['tabindex' => 2]),
                        Checkbox::make('remember')
                            ->label('Ghi nhớ đăng nhập'),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    public function registerAction(): Action
    {
        return Action::make('register')
            ->link()
            ->label('Đăng ký tài khoản')
            ->url(filament()->getRegistrationUrl());
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('authenticate')
                ->label('Đăng nhập')
                ->submit('authenticate'),
        ];
    }
}
