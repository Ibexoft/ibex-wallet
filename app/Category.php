<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['user_id', 'name', 'parent_category_id', 'icon'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent_category()
    {
        return $this->belongsTo(Category::class);
    }
}
