<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function get_user_role_id()
    {
        $role = \App\Role::where('name', 'user')->first();
        return $role->id;
    }

    public function isAdmin()
    {
        // jika role_id nya maka dia false itu user kalo true sebagai admin
        if ($this->role_id === $this->get_user_role_id()) {
            return false;
        }

        return true;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model){
            $model->role_id = $model->get_user_role_id();
        });
    }
}
