<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Permission;
use App\Models\OpdMaster;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AppSetting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->newLine();
        $this->command->info('🚀 Starting Database Seeding...');
        $this->command->newLine();

        // 0. Pre-seeding checks and cleanup
        $this->command->comment('Step 0: Pre-seeding Cleanup & Checks...');

        // Check Storage Link
        if (!File::exists(public_path('storage'))) {
            $this->command->warn('! Storage link missing. Creating it now...');
            $this->command->call('storage:link');
            $this->command->info('✔ Storage link created.');
        } else {
            $this->command->info('✔ Storage link verified.');
        }

        // Clean Directories
        $directoriesToClean = ['avatars', 'banners', 'logo', 'opd_logos'];
        foreach ($directoriesToClean as $dir) {
            if (Storage::disk('public')->exists($dir)) {
                $files = Storage::disk('public')->allFiles($dir);
                if (count($files) > 0) {
                    Storage::disk('public')->delete($files);
                    $this->command->info("✔ Cleaned {$dir} directory.");
                } else {
                    $this->command->info("✔ {$dir} directory is already clean.");
                }
            } else {
                Storage::disk('public')->makeDirectory($dir);
                $this->command->info("✔ Created {$dir} directory.");
            }
        }
        $this->command->newLine();

        // 1. Create Permissions
        $this->command->comment('Step 1: Creating Permissions...');
        $permissions = [
            'user' => [
                'view-user',
                'add-user',
                'edit-user',
                'delete-user',
            ],
            'role-permission' => [
                'view-role-permission',
                'add-role',
                'edit-role',
                'delete-role',
                'add-permission',
                'edit-permission',
                'delete-permission',
            ],
            'example' => [
                'view-example',
                'add-example',
                'edit-example',
                'delete-example',
            ],
            'setting' => [
                'setting-app',
            ],
            'master-opd' => [
                'view-master-opd',
                'add-master-opd',
                'edit-master-opd',
                'delete-master-opd',
            ],
            'agenda' => [
                'view-agenda',
                'add-agenda',
                'edit-agenda',
                'delete-agenda',
                'view-absensi',
                'export-absensi',
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
        $this->command->info('✔ Permissions created successfully.');

        // 2. Create Roles
        $this->command->newLine();
        $this->command->comment('Step 2: Creating Roles...');
        $superAdminRole = Role::updateOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web',
            'color' => '#ff0000'
        ]);
        $adminOpdRole = Role::updateOrCreate([
            'name' => 'admin-opd',
            'guard_name' => 'web',
            'color' => '#007bff'
        ]);
        $userRole = Role::updateOrCreate([
            'name' => 'user',
            'guard_name' => 'web',
            'color' => '#2bff00'
        ]);
        $userExampleRole = Role::updateOrCreate([
            'name' => 'user-example',
            'guard_name' => 'web',
            'color' => '#ff00dd'
        ]);
        $this->command->info('✔ Roles created successfully.');

        // 3. Sync all permissions to Super Admin Role
        $this->command->newLine();
        $this->command->comment('Step 3: Syncing Permissions...');
        $allPermissions = Permission::all();
        $superAdminRole->syncPermissions($allPermissions);
        $this->command->info('✔ All permissions synced to Super Admin.');

        // Sync example permissions to User Example Role
        $examplePermissions = Permission::where('group', 'example')->get();
        $userExampleRole->syncPermissions($examplePermissions);
        $this->command->info('✔ Example permissions synced to User Example Role.');

        // Sync agenda permissions to Admin OPD Role
        $agendaPermissions = Permission::where('group', 'agenda')->get();
        $adminOpdRole->syncPermissions($agendaPermissions);
        $this->command->info('✔ Agenda permissions synced to Admin OPD Role.');

        // 4. Create OPD Masters
        $this->command->newLine();
        $this->command->comment('Step 4: Creating OPD Masters...');

        $opdData = [
            [
                'name' => 'Dinas Komunikasi Informatika dan Statistik',
                'singkatan' => 'DISKOMINFO',
                'address_opd' => 'Jl. A. Rahman Hamid - Komplek Perkantoran Walikota Pekanbaru Gedung Utama Lt. 3',
                'catatan' => 'Dinas kominfo hanya boleh 1 admin, jika ada penambahan mohon konfirmasi ke dinas KOMINFO.',
                'logo_file' => 'public/assets/images/opd_logos/opd_logos.png'
            ]
        ];

        $opdMasters = [];
        foreach ($opdData as $data) {
            $logoFile = $data['logo_file'];
            unset($data['logo_file']);

            if (File::exists(base_path($logoFile))) {
                $logoName = Str::uuid() . '.' . File::extension(base_path($logoFile));
                $logoPath = 'opd_logos/' . $logoName;
                Storage::disk('public')->put($logoPath, File::get(base_path($logoFile)));
                $data['logo_opd'] = $logoPath;
            }

            $opd = OpdMaster::updateOrCreate(['singkatan' => $data['singkatan']], $data);
            $opdMasters[$opd->singkatan] = $opd;
        }
        $this->command->info('✔ OPD Masters created successfully.');

        // 5. Create Users and Assign Roles
        $this->command->newLine();
        $this->command->comment('Step 5: Creating Users & Assigning Roles...');

        $userData = [
            [
                'email' => 'superadmin@mail.com',
                'name' => 'Super Admin',
                'password' => 'password',
                'status' => 'active',
                'phone' => '+6281234567891',
                'address' => 'Jl. Super Admin No. 1',
                'email_verified_at' => now(),
                'role' => 'super-admin',
                'role_obj' => $superAdminRole
            ],
            [
                'email' => 'adminopd@mail.com',
                'name' => 'Admin OPD',
                'password' => 'password',
                'status' => 'active',
                'phone' => '+6281234567890',
                'address' => 'Jl. Raya No. 123, Jakarta',
                'email_verified_at' => now(),
                'role' => 'admin-opd',
                'role_obj' => $adminOpdRole,
                'opd_master_id' => $opdMasters['DISKOMINFO']->id ?? null,
                'custom_files' => [
                    'photo' => 'public/assets/images/avatars/avatar.png',
                    'banner' => 'public/assets/images/banners/banner.jpg',
                ]
            ],
            [
                'email' => 'user@mail.com',
                'name' => 'Regular User',
                'password' => 'password',
                'status' => 'active',
                'phone' => '+6281234567892',
                'address' => 'Jl. User No. 2',
                'email_verified_at' => now(),
                'role' => 'user',
                'role_obj' => $userRole
            ],
            [
                'email' => 'user@example.com',
                'name' => 'User Example',
                'password' => 'string',
                'status' => 'active',
                'phone' => '+6281234567893',
                'address' => 'Jl. Example No. 3',
                'email_verified_at' => now(),
                'role' => 'user-example',
                'role_obj' => $userExampleRole,
                'opd_master_id' => $opdMasters['DISKOMINFO']->id ?? null,
                'custom_files' => [
                    'photo' => 'public/assets/images/avatars/avatar.png',
                    'banner' => 'public/assets/images/banners/banner.jpg',
                ]
            ]
        ];

        $displayUsers = [];
        foreach ($userData as $data) {
            $roleObj = $data['role_obj'];
            $roleName = $data['role'];
            $plainPassword = $data['password'];
            $status = $data['status'];
            $customFiles = $data['custom_files'] ?? null;

            unset($data['role'], $data['role_obj'], $data['custom_files']);

            // Hash password for database
            $data['password'] = Hash::make($plainPassword);

            // Handle Custom Files (Photo & Banner)
            if ($customFiles) {
                if (isset($customFiles['photo']) && File::exists(base_path($customFiles['photo']))) {
                    $photoName = Str::uuid() . '.' . File::extension(base_path($customFiles['photo']));
                    $photoPath = 'avatars/' . $photoName;
                    Storage::disk('public')->put($photoPath, File::get(base_path($customFiles['photo'])));
                    $data['photo'] = $photoPath;
                }

                if (isset($customFiles['banner']) && File::exists(base_path($customFiles['banner']))) {
                    $bannerName = Str::uuid() . '.' . File::extension(base_path($customFiles['banner']));
                    $bannerPath = 'banners/' . $bannerName;
                    Storage::disk('public')->put($bannerPath, File::get(base_path($customFiles['banner'])));
                    $data['banner'] = $bannerPath;
                }
            }

            $user = User::updateOrCreate(['email' => $data['email']], $data);
            $user->assignRole($roleObj);

            $displayUsers[] = [$user->name, $user->email, $plainPassword, $roleName, $status];
        }

        $this->command->table(['Name', 'Email', 'Password', 'Role', 'Status'], $displayUsers);

        $this->command->newLine();
        $this->command->info('✨ Database Seeding Completed Successfully! ✨');
        $this->command->newLine();

        // 6. Initialize App Settings
        $this->command->comment('Step 6: Initializing App Settings...');
        AppSetting::updateOrCreate(
            ['id' => 1],
            [
                'app_name' => 'Agenity',
                'login_title' => '🔐 Login Agenity',
                'login_description' => 'Agenity - Digital Agenda & Attendance Identity System',
            ]
        );
        $this->command->info('✔ App settings initialized.');
    }
}
