<?php

namespace App\Models;

use App\Models\Enums\UserRolesEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements ModelInterface
{
    public const TABLE_NAME = 'users';

    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'roles'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'roles' => 'array'
    ];

    public function isAdmin(): bool
    {
        return in_array(UserRolesEnums::ROLE_CLIENT_ADMIN, $this->getAttribute('roles'), true);
    }

    public function isSuperAdmin(): bool
    {
        return in_array(UserRolesEnums::ROLE_SUPER_ADMIN, $this->getAttribute('roles'), true);
    }
}
