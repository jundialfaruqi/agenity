<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class EventPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'event' => [
                'view-event',
                'add-event',
                'edit-event',
                'delete-event',
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
            $eventPermissions = Permission::where('group', 'event')->get();
            $superAdminRole->givePermissionTo($eventPermissions);
        }

        // Sync to admin-opd
        $adminOpdRole = Role::where('name', 'admin-opd')->first();
        if ($adminOpdRole) {
            $eventPermissions = Permission::where('group', 'event')->get();
            $adminOpdRole->givePermissionTo($eventPermissions);
        }
    }
}
