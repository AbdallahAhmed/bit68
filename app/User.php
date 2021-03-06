<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

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
     * Set password attribute
     * @param $password
     */
    function setPasswordAttribute($password)
    {
        $this->attributes["password"] = Hash::make($password);
    }

    /**
     * generate API token
     * @return string
     */
    static function newApiToken()
    {
        return str_random(60);
    }
}
