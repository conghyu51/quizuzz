<?php

namespace App\Providers\Filament;

use App\View\Components\LoginButton;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->path('app')
            ->login()
            ->registration()
            ->spa()
            ->colors([
                'primary' => Color::Sky,
            ])
            ->topNavigation()
            ->font('Be Vietnam Pro')
            ->maxContentWidth(MaxWidth::FiveExtraLarge)
            ->renderHook(
                PanelsRenderHook::TOPBAR_END,
                static fn(): ?string => !filament()->auth()->check() ?
                    Blade::renderComponent(new LoginButton())
                    : null,
            )
            ->darkMode(false)
            ->viteTheme('resources/css/filament/app/theme.css')
            ->discoverResources(app_path('Filament/App/Resources'), 'App\\Filament\\App\\Resources')
            ->discoverPages(app_path('Filament/App/Pages'), 'App\\Filament\\App\\Pages')
            ->discoverWidgets(app_path('Filament/App/Widgets'), 'App\\Filament\\App\\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([]);
    }
}
