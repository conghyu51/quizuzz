<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LoginButton extends Component
{
    public function render(): string
    {
        return <<<BLADE
            <x-filament::button href="{{ route('filament.app.auth.login') }}" tag="a" wire:navigate>
                Đăng nhập
            </x-filament::button>
        BLADE;
    }
}
