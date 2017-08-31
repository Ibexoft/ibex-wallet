<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['user_id', 'name', 'type', 'currency'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
