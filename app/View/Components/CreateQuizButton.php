<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CreateQuizButton extends Component
{
    public function render(): string
    {
        return <<<BLADE
            <x-filament::button href="#" tag="a" wire:navigate>
                Tạo Quiz
            </x-filament::button>
        BLADE;
    }
}
