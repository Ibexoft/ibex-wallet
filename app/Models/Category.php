<?php

namespace App\Models;

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
        return $this->belongsTo(self::class, 'parent_category_id');
    }

    public function subcategories()
    {
        return $this->hasMany(self::class, 'parent_category_id');
    }

    public static function bulkCreateForUser(int $userId, array $subCategories = null, $category = null, Category $parentCategory = null)
    {
        $parentCat = null;

        if ($category) {
            // Extract icon if it's present
            $icon = $subCategories['icon'] ?? null;

            $found = self::where('user_id', $userId)
                ->where('name', $category)
                ->where('parent_category_id', $parentCategory ? $parentCategory->id : null)
                ->count();

            if ($found > 0) {
                return;
            }

            $parentCat = self::create([
                'user_id'               => $userId,
                'name'                  => $category,
                'parent_category_id'    => $parentCategory ? $parentCategory->id : null,
                'icon'                  => $icon, // Save the icon
            ]);
        }

        if (is_array($subCategories)) {
            foreach ($subCategories as $categoryName => $subCats) {
                // Skip 'icon' key to avoid treating it as a subcategory
                if ($categoryName === 'icon') {
                    continue;
                }

                if (is_array($subCats)) {
                    self::bulkCreateForUser($userId, $subCats, $categoryName, $parentCat);
                } else {
                    self::bulkCreateForUser($userId, null, $subCats, $parentCat);
                }
            }
        }
    }
}
