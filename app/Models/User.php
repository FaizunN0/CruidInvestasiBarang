<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name','email','password','role'
    ];

    protected $hidden = [
        'password','remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    // relasi ke permissions (pivot user_permission)
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permission')->withTimestamps();
    }

    // relasi ke barang
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'user_id');
    }

    // role helpers
    public function isSuper(): bool { return $this->role === 'super'; }
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isUser(): bool { return $this->role === 'user'; }

    // cek single permission
    public function hasPermission(string $name): bool
    {
        if ($this->isSuper()) return true;

        if ($this->relationLoaded('permissions')) {
            return $this->permissions->contains('name', $name);
        }
        return $this->permissions()->where('name', $name)->exists();
    }

    // cek banyak permission (any)
    public function hasAnyPermission(array $names): bool
    {
        if ($this->isSuper()) return true;
        foreach ($names as $n) {
            if ($this->hasPermission($n)) return true;
        }
        return false;
    }
}
