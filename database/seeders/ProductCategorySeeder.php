<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $product_category = [
            [
                'id'             => 1,
                'name'           => 'Service',
                'active'         => 1,
                'created_at'     => '2023-10-25 18:46:47',
                'updated_at'     => '2023-10-25 18:46:47',
            ],
            [
                'id'             => 2,
                'name'           => 'Goods',
                'active'         => 1,
                'created_at'     => '2023-10-25 18:46:47',
                'updated_at'     => '2023-10-25 18:46:47',
            ],
        ];

        ProductCategory::insert($product_category);
    }
}
