<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            "Household" => [
                "Grocery" => [
                    "Food",
                    "Breakfast",
                    "Refreshment"
                ],
                "Toileteries and Personal Supplies",
                "Household Supplies",
                "Family expenses",
                "Housing" => [
                    "Rent",
                    "Repair & Maintenance",
                    "Bills" => [
                        "Electricity",
                        "Gas",
                        "Water",
                        "Internet",
                        "Mobile balance",
                        "Maid",
                        "Sewerage",
                        "Trash"
                    ]
                ]
            ],
            "Personal Care",
            "Education" => [
                "School Fee",
                "Stationary, Books, & Supplies",
                "Uniforms, Suits",
                "Qari, Tution"
            ],
            "Healthcare" => [
                "Doctor",
                "Medicine"
            ],
            "Entertainment" => [
                "Restaurant",
                "Cafe",
                "Order Food",
                "Outing, Picnic"
            ],
            "Vehicle" => [
                "Fuel" => [
                    "Petrol",
                    "CNG",
                    "Diesel"
                ],
                "Maintenance",
                "Repair",
                "Taxes and Documentation"
            ],
            "Shopping" => [
                "Apparel",
                "Beauty, Cosmetics, & Accessories",
                "Other"
            ],
            "Religious" => [
                "Zakat",
                "Sadqa",
                "Qurbani",
                "Hajj, Umrah"
            ],
            "Gifts",
            "Home Renovation & Decor",
            "Transportation" => [
                "Parking",
                "Tolls",
                "Taxi"
            ],
            "Other" => [
                "Bank and ATM Fee"
            ],
            "Income" => [
                "Job, Salary",
                "Profit on business",
                "Sell",
                "Other"
            ]
        ];

        $this->create(App\User::first()->id, $categories);
    }

    protected function create(int $userId, array $subCategories = null, $category = null, App\Category $parentCategory = null) {
        $parentCat = null;

        if ($category) {
            $found = App\Category::where('user_id', $userId)
                        ->where('name', $category)
                        ->where('parent_category_id', $parentCategory ? $parentCategory->id : null)
                        ->get()
                        ->count();

            if ($found > 0) {
                return;
            }

            $parentCat = App\Category::create([
                'user_id'               => $userId,
                'name'                  => $category,
                'parent_category_id'    => $parentCategory ? $parentCategory->id : null
            ]);
        }

        if (is_array($subCategories)) {
            foreach ($subCategories as $categoryName => $subCats) {
                if (is_array($subCats)) {
                    $this->create($userId, $subCats, $categoryName, $parentCat);
                    continue;
                }
                $this->create($userId, null, $subCats, $parentCat);
            }
        }
    }
}
