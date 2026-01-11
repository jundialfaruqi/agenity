<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class UsersService
{
    public function listUsers(?string $search = null, ?string $role = null, ?string $status = null, int $perPage = 10)
    {
        $query = User::query()->with(['roles', 'opdMaster']);
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhereHas('roles', function ($rq) use ($search) {
                        $rq->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('opdMaster', function ($oq) use ($search) {
                        $oq->where('name', 'like', '%' . $search . '%')
                            ->orWhere('singkatan', 'like', '%' . $search . '%');
                    });
            });
        }
        if ($status) {
            $query->where('status', $status);
        }
        if ($role) {
            $query->whereHas('roles', function ($rq) use ($role) {
                $rq->where('name', $role);
            });
        }
        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getStats(): array
    {
        return [
            'total' => User::query()->count(),
            'active' => User::query()->where('status', 'active')->count(),
            'pending' => User::query()->where('status', 'pending')->count(),
            'inactive' => User::query()->where('status', 'inactive')->count(),
        ];
    }

    public function suggestUsers(string $search): Collection
    {
        return User::query()
            ->with(['roles', 'opdMaster'])
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhereHas('roles', function ($rq) use ($search) {
                        $rq->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('opdMaster', function ($oq) use ($search) {
                        $oq->where('name', 'like', '%' . $search . '%')
                            ->orWhere('singkatan', 'like', '%' . $search . '%');
                    });
            })
            ->orderBy('name')
            ->limit(5)
            ->get()
            ->map(function (User $u) {
                return [
                    'id' => $u->id,
                    'name' => $u->name,
                    'email' => $u->email,
                    'status' => $u->status,
                    'role' => $u->getRoleNames()->first(),
                    'opd' => $u->opdMaster ? "({$u->opdMaster->singkatan}) {$u->opdMaster->name}" : null,
                ];
            });
    }

    public function createUser(array $data, ?\Illuminate\Http\UploadedFile $photo = null): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'status' => $data['status'] ?? 'active',
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'opd_master_id' => $data['opd_master_id'] ?? null,
        ]);
        if ($photo) {
            $path = $this->processAndStorePhoto($photo);
            $user->photo = $path;
            $user->save();
        }
        if (!empty($data['role'])) {
            $user->assignRole($data['role']);
        }
        return $user;
    }

    public function updateUser(User $user, array $data, ?\Illuminate\Http\UploadedFile $photo = null, ?\Illuminate\Http\UploadedFile $banner = null): User
    {
        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = $data['password'];
        }
        if (isset($data['status'])) {
            $user->status = $data['status'];
        }
        $user->phone = $data['phone'] ?? $user->phone;
        $user->address = $data['address'] ?? $user->address;

        if (array_key_exists('opd_master_id', $data)) {
            $user->opd_master_id = $data['opd_master_id'];
        }
        if (!empty($data['role'])) {
            $user->syncRoles([$data['role']]);
        }

        // Handle Photo Removal
        if (isset($data['remove_photo']) && $data['remove_photo'] == '1') {
            if ($user->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->photo);
                $user->photo = null;
            }
        }

        if ($photo) {
            if ($user->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->photo);
            }
            $path = $this->processAndStorePhoto($photo);
            $user->photo = $path;
        }

        // Handle Banner Removal
        if (isset($data['remove_banner']) && $data['remove_banner'] == '1') {
            if ($user->banner) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->banner);
                $user->banner = null;
            }
        }

        if ($banner) {
            if ($user->banner) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->banner);
            }
            $path = $this->processAndStoreBanner($banner);
            $user->banner = $path;
        }

        $user->save();
        return $user;
    }

    protected function processAndStoreBanner(\Illuminate\Http\UploadedFile $file): string
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($ext, $allowed, true)) {
            throw new \InvalidArgumentException('Format gambar tidak didukung.');
        }

        // Banners usually have different aspect ratios, so we might not want to crop it square like avatars
        // But for consistency, let's just store it. We can resize it if needed.
        $filename = \Illuminate\Support\Str::uuid()->toString() . '.' . $ext;
        $path = $file->storeAs('banners', $filename, 'public');
        return $path;
    }

    protected function processAndStorePhoto(\Illuminate\Http\UploadedFile $file): string
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($ext, $allowed, true)) {
            throw new \InvalidArgumentException('Format gambar tidak didukung.');
        }
        $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
        $image = $manager->read($file->getPathname());
        $w = $image->width();
        $h = $image->height();
        $size = min($w, $h);
        $x = (int) floor(($w - $size) / 2);
        $y = (int) floor(($h - $size) / 2);
        $image = $image->crop($size, $size, $x, $y);
        $filename = \Illuminate\Support\Str::uuid()->toString() . '.' . $ext;
        $encoded = $image->encodeByExtension($ext, 85);
        \Illuminate\Support\Facades\Storage::disk('public')->put('avatars/' . $filename, $encoded);
        return 'avatars/' . $filename;
    }
}
