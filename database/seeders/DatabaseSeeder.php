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

        // Clean public/uploads/editor
        $editorPath = public_path('uploads/editor');
        if (File::exists($editorPath)) {
            $editorFiles = File::files($editorPath);
            if (count($editorFiles) > 0) {
                File::cleanDirectory($editorPath);
                $this->command->info("✔ Cleaned public/uploads/editor directory.");
            } else {
                $this->command->info("✔ public/uploads/editor is already clean.");
            }
        } else {
            File::makeDirectory($editorPath, 0755, true);
            $this->command->info("✔ Created public/uploads/editor directory.");
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
            'survey' => [
                'view-survey',
                'add-survey',
                'edit-survey',
                'delete-survey',
                'view-survey-result',
            ],
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

        // Sync agenda, survey & event permissions to Admin OPD Role
        $adminOpdPermissions = Permission::whereIn('group', ['agenda', 'survey', 'event'])->get();
        $adminOpdRole->syncPermissions($adminOpdPermissions);
        $this->command->info('✔ Agenda, Survey & Event permissions synced to Admin OPD Role.');

        // 4. Create OPD Masters
        $this->command->newLine();
        $this->command->comment('Step 4: Creating OPD Masters...');

        $opdData = [
            [
                'name' => 'Dinas Komunikasi Informatika Statistik dan Persandian Pekanbaru',
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

        // 6. Initialize App Settings
        $this->command->newLine();
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

        // 7. Create Sample Survey
        $this->command->newLine();
        $this->command->comment('Step 7: Creating Sample Survey...');
        $adminUser = User::where('email', 'adminopd@mail.com')->first();
        if ($adminUser) {
            $surveys = [
                [
                    'title' => 'Survei Kepuasan Masyarakat 2026',
                    'description' => 'Kami ingin mendengar pendapat Anda mengenai layanan kami.',
                ],
                [
                    'title' => 'Survei Kebutuhan Fasilitas Publik',
                    'description' => 'Bantu kami meningkatkan kualitas fasilitas umum di kota ini.',
                ],
                [
                    'title' => 'Evaluasi Layanan Digital OPD',
                    'description' => 'Sejauh mana efektivitas aplikasi layanan publik kami?',
                ],
            ];

            foreach ($surveys as $sData) {
                $survey = \App\Models\Survey::create([
                    'opd_id' => $adminUser->opd_master_id,
                    'created_by' => $adminUser->id,
                    'title' => $sData['title'],
                    'description' => $sData['description'],
                    'start_date' => now(),
                    'end_date' => now()->addMonth(),
                    'is_active' => true,
                    'visibility' => 'public',
                ]);

                $questions = [
                    [
                        'question_text' => 'Bagaimana penilaian Anda terhadap kualitas layanan kami?',
                        'type' => 'rating',
                        'is_required' => true,
                    ],
                    [
                        'question_text' => 'Fasilitas apa yang paling penting bagi Anda?',
                        'type' => 'multiple_choice',
                        'is_required' => true,
                        'options' => ['Ruang Tunggu', 'Kebersihan', 'Parkir', 'Aksesibilitas'],
                    ],
                    [
                        'question_text' => 'Berikan saran Anda.',
                        'type' => 'text',
                        'is_required' => false,
                    ],
                ];

                foreach ($questions as $q) {
                    $question = $survey->questions()->create([
                        'question_text' => $q['question_text'],
                        'type' => $q['type'],
                        'is_required' => $q['is_required'],
                    ]);

                    if (isset($q['options'])) {
                        foreach ($q['options'] as $optionText) {
                            $question->options()->create(['option_text' => $optionText]);
                        }
                    }
                }
            }
            $this->command->info('✔ 3 Sample surveys created.');
        }

        // 8. Create Sample Agenda
        $this->command->newLine();
        $this->command->comment('Step 8: Creating Sample Agenda...');
        if ($adminUser) {
            $agendas = [
                [
                    'title' => 'Rapat Koordinasi Evaluasi Kinerja Bulanan',
                    'jenis_agenda' => 'Rapat Internal',
                    'mode' => 'offline',
                    'date' => now()->format('Y-m-d'),
                    'start_time' => '08:30',
                    'end_time' => '11:00',
                    'location' => 'Ruang Rapat DISKOMINFO Lt. 3',
                ],
                [
                    'title' => 'Rapat Teknis Pengembangan Smart City',
                    'jenis_agenda' => 'Rapat Teknis',
                    'mode' => 'online',
                    'date' => now()->addDay()->format('Y-m-d'),
                    'start_time' => '13:00',
                    'end_time' => '15:30',
                    'location' => 'Zoom Meeting',
                ],
                [
                    'title' => 'Coffee Morning & Briefing Pagi',
                    'jenis_agenda' => 'Briefing',
                    'mode' => 'offline',
                    'date' => now()->addDays(2)->format('Y-m-d'),
                    'start_time' => '07:30',
                    'end_time' => '09:00',
                    'location' => 'Lobby Gedung Utama',
                ],
            ];

            foreach ($agendas as $aData) {
                $formattedDate = \Carbon\Carbon::parse($aData['date'])->format('j-n-Y');
                $baseSlug = Str::slug($aData['title']);
                $slug = $formattedDate . '/' . $baseSlug;

                // Simple uniqueness check for seeder
                $count = 1;
                while (\App\Models\Agenda::where('slug', $slug)->exists()) {
                    $slug = $formattedDate . '/' . $baseSlug . '-' . $count;
                    $count++;
                }

                $agenda = \App\Models\Agenda::create([
                    'master_opd_id' => $adminUser->opd_master_id,
                    'user_id' => $adminUser->id,
                    'title' => $aData['title'],
                    'slug' => $slug,
                    'jenis_agenda' => $aData['jenis_agenda'],
                    'mode' => $aData['mode'],
                    'date' => $aData['date'],
                    'start_time' => $aData['start_time'],
                    'end_time' => $aData['end_time'],
                    'location' => $aData['location'],
                    'content' => '<p>Deskripsi contoh untuk agenda ' . $aData['title'] . '.</p>',
                    'catatan' => 'Catatan tambahan untuk agenda ini.',
                    'status' => 'active',
                    'visibility' => 'public',
                    'wifi_name' => 'DISKOMINFO_GUEST',
                    'password_wifi' => 'pekanbaru2026',
                ]);

                $agenda->sessions()->create([
                    'session_name' => 'Sesi Utama',
                    'session_type' => $aData['mode'] === 'online' ? 'online' : 'offline',
                    'token' => \Illuminate\Support\Str::random(32),
                    'qr_code_path' => 'qrcodes/sample-qr.png',
                    'start_at' => \Carbon\Carbon::parse($aData['date'] . ' ' . $aData['start_time']),
                    'end_at' => \Carbon\Carbon::parse($aData['date'] . ' ' . $aData['end_time']),
                    'is_active' => true,
                ]);
            }

            $this->command->info('✔ 3 Sample agendas created.');
        }

        // 9. Create Sample Event
        $this->command->newLine();
        $this->command->comment('Step 9: Creating Sample Event...');
        if ($adminUser) {
            $events = [
                [
                    'title' => 'Workshop Digitalisasi Pelayanan Publik',
                    'jenis_event' => 'Workshop',
                    'mode' => 'offline',
                    'date' => now()->addDays(7)->format('Y-m-d'),
                ],
                [
                    'title' => 'Sosialisasi Aplikasi Agenity',
                    'jenis_event' => 'Sosialisasi',
                    'mode' => 'online',
                    'date' => now()->addDays(2)->format('Y-m-d'),
                ],
                [
                    'title' => 'Seminar Keamanan Cyber 2026',
                    'jenis_event' => 'Seminar',
                    'mode' => 'offline',
                    'date' => now()->addDays(14)->format('Y-m-d'),
                ],
            ];

            foreach ($events as $eData) {
                $formattedDate = \Carbon\Carbon::parse($eData['date'])->format('j-n-Y');
                $baseSlug = Str::slug($eData['title']);
                $slug = $formattedDate . '/' . $baseSlug;

                // Simple uniqueness check for seeder
                $count = 1;
                while (\App\Models\Event::where('slug', $slug)->exists()) {
                    $slug = $formattedDate . '/' . $baseSlug . '-' . $count;
                    $count++;
                }

                \App\Models\Event::create([
                    'master_opd_id' => $adminUser->opd_master_id,
                    'user_id' => $adminUser->id,
                    'title' => $eData['title'],
                    'slug' => $slug,
                    'jenis_event' => $eData['jenis_event'],
                    'mode' => $eData['mode'],
                    'date' => $eData['date'],
                    'start_time' => '09:00',
                    'end_time' => '12:00',
                    'location' => $eData['mode'] === 'online' ? 'Zoom Meeting' : 'Aula Lantai 1 Gedung Utama',
                    'content' => '<p>Deskripsi contoh untuk event ' . $eData['title'] . '.</p>',
                    'status' => 'active',
                ]);
            }

            $this->command->info('✔ 3 Sample events created.');
        }

        $this->command->newLine();
        $this->command->info('✨ Database Seeding Completed Successfully! ✨');
    }
}
