<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $guarded = [];

    /**
     * Get the user that owns the account.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
