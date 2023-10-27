<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'crm_contact_create',
            ],
            [
                'id'    => 20,
                'title' => 'crm_contact_edit',
            ],
            [
                'id'    => 21,
                'title' => 'crm_contact_show',
            ],
            [
                'id'    => 22,
                'title' => 'crm_contact_delete',
            ],
            [
                'id'    => 23,
                'title' => 'crm_contact_access',
            ],
            [
                'id'    => 24,
                'title' => 'task_management_access',
            ],
            [
                'id'    => 25,
                'title' => 'task_status_create',
            ],
            [
                'id'    => 26,
                'title' => 'task_status_edit',
            ],
            [
                'id'    => 27,
                'title' => 'task_status_show',
            ],
            [
                'id'    => 28,
                'title' => 'task_status_delete',
            ],
            [
                'id'    => 29,
                'title' => 'task_status_access',
            ],
            [
                'id'    => 30,
                'title' => 'task_tag_create',
            ],
            [
                'id'    => 31,
                'title' => 'task_tag_edit',
            ],
            [
                'id'    => 32,
                'title' => 'task_tag_show',
            ],
            [
                'id'    => 33,
                'title' => 'task_tag_delete',
            ],
            [
                'id'    => 34,
                'title' => 'task_tag_access',
            ],
            [
                'id'    => 35,
                'title' => 'task_create',
            ],
            [
                'id'    => 36,
                'title' => 'task_edit',
            ],
            [
                'id'    => 37,
                'title' => 'task_show',
            ],
            [
                'id'    => 38,
                'title' => 'task_delete',
            ],
            [
                'id'    => 39,
                'title' => 'task_access',
            ],
            [
                'id'    => 40,
                'title' => 'tasks_calendar_access',
            ],
            [
                'id'    => 41,
                'title' => 'crm_product_create',
            ],
            [
                'id'    => 42,
                'title' => 'crm_product_edit',
            ],
            [
                'id'    => 43,
                'title' => 'crm_product_show',
            ],
            [
                'id'    => 44,
                'title' => 'crm_product_delete',
            ],
            [
                'id'    => 45,
                'title' => 'crm_product_access',
            ],
            [
                'id'    => 46,
                'title' => 'product_category_create',
            ],
            [
                'id'    => 47,
                'title' => 'product_category_edit',
            ],
            [
                'id'    => 48,
                'title' => 'product_category_show',
            ],
            [
                'id'    => 49,
                'title' => 'product_category_delete',
            ],
            [
                'id'    => 50,
                'title' => 'product_category_access',
            ],
            [
                'id'    => 51,
                'title' => 'setting_access',
            ],
            [
                'id'    => 52,
                'title' => 'deal_stage_create',
            ],
            [
                'id'    => 53,
                'title' => 'deal_stage_edit',
            ],
            [
                'id'    => 54,
                'title' => 'deal_stage_show',
            ],
            [
                'id'    => 55,
                'title' => 'deal_stage_delete',
            ],
            [
                'id'    => 56,
                'title' => 'deal_stage_access',
            ],
            [
                'id'    => 57,
                'title' => 'deal_create',
            ],
            [
                'id'    => 58,
                'title' => 'deal_edit',
            ],
            [
                'id'    => 59,
                'title' => 'deal_show',
            ],
            [
                'id'    => 60,
                'title' => 'deal_delete',
            ],
            [
                'id'    => 61,
                'title' => 'deal_access',
            ],
            [
                'id'    => 62,
                'title' => 'deal_source_create',
            ],
            [
                'id'    => 63,
                'title' => 'deal_source_edit',
            ],
            [
                'id'    => 64,
                'title' => 'deal_source_show',
            ],
            [
                'id'    => 65,
                'title' => 'deal_source_delete',
            ],
            [
                'id'    => 66,
                'title' => 'deal_source_access',
            ],
            [
                'id'    => 67,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
