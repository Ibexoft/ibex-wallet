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
        return $this->belongsTo(self::class);
    }

    public static function bulkCreateForUser(int $userId, array $subCategories = null, $category = null, Category $parentCategory = null)
    {
        $parentCat = null;

        if ($category) {
            $found = self::where('user_id', $userId)
                        ->where('name', $category)
                        ->where('parent_category_id', $parentCategory ? $parentCategory->id : null)
                        ->get()
                        ->count();

            if ($found > 0) {
                return;
            }

            $parentCat = self::create([
                'user_id'               => $userId,
                'name'                  => $category,
                'parent_category_id'    => $parentCategory ? $parentCategory->id : null,
            ]);
        }

        if (is_array($subCategories)) {
            foreach ($subCategories as $categoryName => $subCats) {
                if (is_array($subCats)) {
                    self::bulkCreateForUser($userId, $subCats, $categoryName, $parentCat);
                    continue;
                }
                self::bulkCreateForUser($userId, null, $subCats, $parentCat);
            }
        }
    }
}
