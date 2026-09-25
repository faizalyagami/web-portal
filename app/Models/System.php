<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class System extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'url',
        'description',
        'icon',
        'color',
        'category',
        'is_active',
        'order'
    ];

    protected $casts = [
        'allowed_types' => 'array',
        'is_active' => 'boolean',
    ];

    public function isAccessibleBy(User $user): bool
    {
        if ($user->is_super_admin) return true;

        if (!empty($this->allowed_types)) {
            $userType = $user->user_type instanceof \App\Enums\UserType
                ? $user->user_type->value
                : $user->user_type;

            if (!in_array($userType, $this->allowed_types, true)) {
                return false;
            }
        }

        return true;
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_system_access')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
