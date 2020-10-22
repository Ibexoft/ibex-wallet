<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user accounts.
     */
    public function accounts()
    {
        return $this->hasMany('App\Account');
    }

    /**
     * Get the user wallets.
     */
    public function wallets()
    {
        return $this->hasMany('App\Wallet');
    }

    /**
     * Get the user categories.
     */
    public function categories()
    {
        return $this->hasMany('App\Category');
    }

    /**
     * Get the user transactions.
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
