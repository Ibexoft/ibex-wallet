<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['user_id', 'name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class);
    }

    public function getRouteKeyName()
    {
        return 'name';
    }
}
