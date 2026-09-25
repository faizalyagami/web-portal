<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'identifier',
        'nidn',
        'nik',
        'fakultas',
        'program_studi',
        'jabatan',
        'angkatan',
        'phone',
        'avatar',
        'is_active',
        'is_super_admin',
        'last_login_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'is_super_admin' => 'boolean',
        'user_type' => UserType::class,
    ];

    // === RELASI ===
    public function systems(): BelongsToMany
    {
        return $this->belongsToMany(System::class, 'user_system_access')
            ->withPivot('role')
            ->withTimestamps();
    }

    // === HELPERS ===
    public function hasAccessTo(System $system): bool
    {
        if ($this->is_super_admin) return true;
        return $this->systems()->where('systems.id', $system->id)->exists();
    }

    public function isMahasiswa(): bool
    {
        return $this->user_type === UserType::MAHASISWA;
    }
    public function isDosen(): bool
    {
        return $this->user_type === UserType::DOSEN;
    }
    public function isStaff(): bool
    {
        return $this->user_type === UserType::STAFF;
    }
    public function isAdmin(): bool
    {
        return $this->user_type === UserType::ADMIN;
    }

    public function getIdentifierLabelAttribute(): string
    {
        return $this->user_type->identifierLabel();
    }

    public function getInitialsAttribute(): string
    {
        $parts = explode(' ', trim($this->name));
        if (count($parts) >= 2) {
            return strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }

    // === SCOPES ===
    public function scopeMahasiswa($q)
    {
        return $q->where('user_type', UserType::MAHASISWA);
    }
    public function scopeDosen($q)
    {
        return $q->where('user_type', UserType::DOSEN);
    }
    public function scopeStaff($q)
    {
        return $q->where('user_type', UserType::STAFF);
    }
    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }
}
