<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
implements MustVerifyEmail {
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attribute for table related to this model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'role_id',
        'status',
        'password',
    ];

    /**
     * The attributes that will be set by SoftDeletes action
     *
     * @var array<string>
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if the user has the specified role.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole(int $role): bool
    {
        // Check if the authenticated user has the specified role
        return $this->role()->where('id', $role)->exists();
    }

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function isSuperAdmin()
    {
        // Check if the authenticated user has the specified role
        return $this->id == config('panel.super_admin');
    }

    public function isNotSuperAdmin()
    {
        // Check if the authenticated user has the specified role
        return $this->id != config('panel.super_admin');
    }

    public function isAdmin()
    {
        // Check if the authenticated user has the specified role
        return $this->role()->where('id', config('panel.admin_role_id'))->exists();
    }

}
