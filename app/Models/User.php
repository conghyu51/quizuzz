<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser, HasName
{
    protected $fillable = [
        'username',
        'password',
        'is_teacher',
        'last_login_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentName(): string
    {
        return $this->username;
    }

    protected function casts(): array
    {
        return [
            'is_teacher' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }
}
