<?php

namespace App\Filament\App\Pages;

use Filament\Pages\Page;

class Home extends Page
{
    protected static ?string $title = 'Trang chủ';
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.app.pages.home';
    protected static ?string $slug = '/';
}
