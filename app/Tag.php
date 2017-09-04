<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['user_id', 'name'];

    public function transactions()
    {
        return $this->belongsToMAny(Transaction::class);
    }

    public function getRouteKeyName()
    {
        return 'name';
    }
}
