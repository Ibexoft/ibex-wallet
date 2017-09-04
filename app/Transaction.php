<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'amount', 'type', 'description', 'from_account_id', 'to_account_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function from_account()
    {
        return $this->belongsTo(Account::class);
    }

    public function to_account()
    {
        return $this->belongsTo(Account::class);
    }
}
