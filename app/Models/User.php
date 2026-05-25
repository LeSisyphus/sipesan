<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nim',
        'email',
        'password',
        'role',
        'status',
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

    /**
     * Get the user's initials.
     */
    public function getInisialAttribute()
    {
        $name = $this->name ?? '';
        return collect(explode(' ', $name))
            ->filter()
            ->map(fn($w) => substr($w, 0, 1))
            ->take(2)
            ->implode('');
    }

    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }

    // Helper cek role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }
}