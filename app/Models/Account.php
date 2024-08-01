<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['user_id', 'name', 'type', 'icon', 'currency', 'balance'];

    /**
     * Get the user that owns the account.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
