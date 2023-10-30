<?php

namespace Database\Seeders;

use App\Models\DealStage;
use Illuminate\Database\Seeder;

class DealStageSeeder extends Seeder
{

    public function run()
    {
        $deal_stage = [
            [
                'id'             => 1,
                'order'             => 1,
                'name'           => 'Prospecting',
                'created_at'     => '2023-10-25 18:46:47',
                'updated_at'     => '2023-10-25 18:46:47',
            ],
            [
                'id'             => 2,
                'order'             => 2,
                'name'           => 'Qualification',
                'created_at'     => '2023-10-25 18:46:47',
                'updated_at'     => '2023-10-25 18:46:47',
            ],
            [
                'id'             => 3,
                'order'             => 3,
                'name'           => 'Demo or Meeting',
                'created_at'     => '2023-10-25 18:46:47',
                'updated_at'     => '2023-10-25 18:46:47',
            ],
            [
                'id'             => 4,
                'order'             => 4,
                'name'           => 'Proposal',
                'created_at'     => '2023-10-25 18:46:47',
                'updated_at'     => '2023-10-25 18:46:47',
            ],
            [
                'id'             => 5,
                'order'             => 5,
                'name'           => 'Negotiation',
                'created_at'     => '2023-10-25 18:46:47',
                'updated_at'     => '2023-10-25 18:46:47',
            ],
            [
                'id'             => 6,
                'order'             => 6,
                'name'           => 'Closed won',
                'created_at'     => '2023-10-25 18:46:47',
                'updated_at'     => '2023-10-25 18:46:47',
            ],
            [
                'id'             => 7,
                'order'             => 7,
                'name'           => 'Closed lost',
                'created_at'     => '2023-10-25 18:46:47',
                'updated_at'     => '2023-10-25 18:46:47',
            ],
        ];

        DealStage::insert($deal_stage);
    }
}
