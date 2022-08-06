<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $arrPermissions = [
            'staff' => [
                'list staff',
                'show staff',
                'add staff',
                'edit staff',
                'delete staff'
            ],
            'role' => [
                'list role',
                'show role',
                'add role',
                'edit role',
                'delete role'
            ],
            'category' => [
                'list category',
                'show category',
                'add category',
                'edit category',
                'delete category'
            ],
            'post' => [
                'list post',
                'show post',
                'add post',
                'edit post',
                'delete post',
                'approve post'
            ],
            'page' => [
                'list page',
                'show page',
                'add page',
                'edit page',
                'delete page'
            ],
            'menu' => [
                'list menu',
                'show menu',
                'add menu',
                'edit menu',
                'delete menu'
            ],
            'classified-category' => [
                'list classified-category',
                'show classified-category',
                'add classified-category',
                'edit classified-category',
                'delete classified-category'
            ],
            'classified-post' => [
                'list classified-post',
                'show classified-post',
                'add classified-post',
                'edit classified-post',
                'delete classified-post',
                'approve classified-post'
            ],
        ];

        if (!empty($arrPermissions)) {
            foreach($arrPermissions as $key => $apArr) {
                foreach($apArr as $ap) {
                    Permission::updateOrCreate(['module_name' => $key, 'name' => $ap, 'guard_name' => 'admin'], ['module_name' => $key, 'name' => $ap, 'guard_name' => 'admin']);
                }
            }
        }
    }
}
