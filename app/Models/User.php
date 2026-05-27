<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    const ROLE_CLASSES = [
        'admin'   => 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300',
        'support' => 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300',
        'user'    => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
    ];

    public function roleClass(): string
    {
        return self::ROLE_CLASSES[$this->role] ?? self::ROLE_CLASSES['user'];
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSupport(): bool
    {
        return $this->role === 'support';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}