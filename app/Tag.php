<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function transactions()
    {
        return $this->belongsToMAny(Transaction::class);
    }

    public function getRouteKeyName()
    {
        return 'name';
    }
}
