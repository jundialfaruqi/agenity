<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SurveyPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'survey' => [
                'view-survey',
                'add-survey',
                'edit-survey',
                'delete-survey',
                'view-survey-result',
            ],
        ];

        foreach ($permissions as $group => $permissionList) {
            foreach ($permissionList as $permission) {
                Permission::updateOrCreate(
                    [
                        'name' => $permission,
                        'guard_name' => 'web'
                    ],
                    ['group' => $group]
                );
            }
        }

        // Sync to super-admin
        $superAdminRole = Role::where('name', 'super-admin')->first();
        if ($superAdminRole) {
            $surveyPermissions = Permission::where('group', 'survey')->get();
            $superAdminRole->givePermissionTo($surveyPermissions);
        }

        // Sync to admin-opd
        $adminOpdRole = Role::where('name', 'admin-opd')->first();
        if ($adminOpdRole) {
            $surveyPermissions = Permission::where('group', 'survey')->get();
            $adminOpdRole->givePermissionTo($surveyPermissions);
        }
    }
}
