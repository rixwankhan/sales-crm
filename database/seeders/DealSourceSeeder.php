<?php

namespace Database\Seeders;

use App\Models\DealSource;
use Illuminate\Database\Seeder;

class DealSourceSeeder extends Seeder
{
    public function run()
    {
        $deal_source = [
            [
                'id'             => 1,
                'name'           => 'Web',
                'created_at'     => '2023-10-25 18:46:47',
                'updated_at'     => '2023-10-25 18:46:47',
            ],
            [
                'id'             => 2,
                'name'           => 'Email',
                'created_at'     => '2023-10-25 18:46:47',
                'updated_at'     => '2023-10-25 18:46:47',
            ],
            [
                'id'             => 3,
                'name'           => 'Call',
                'created_at'     => '2023-10-25 18:46:47',
                'updated_at'     => '2023-10-25 18:46:47',
            ],
            
        ];

        DealSource::insert($deal_source);
    }
}
