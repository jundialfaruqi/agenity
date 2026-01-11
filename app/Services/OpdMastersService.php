<?php

namespace App\Services;

namespace App\Services;

use App\Models\OpdMaster;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OpdMastersService
{
    public function listOpds(?string $search = null, int $perPage = 10)
    {
        $query = OpdMaster::query();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('singkatan', 'like', '%' . $search . '%')
                    ->orWhere('address_opd', 'like', '%' . $search . '%');
            });
        }
        return $query->orderBy('name', 'asc')->paginate($perPage);
    }

    public function getStats(): array
    {
        return [
            'total' => OpdMaster::query()->count(),
            'total_users' => \App\Models\User::query()->count(),
            'new_this_month' => OpdMaster::query()->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            'without_address' => OpdMaster::query()->whereNull('address_opd')->orWhere('address_opd', '')->count(),
        ];
    }

    public function suggestOpds(?string $search = null, ?int $id = null): Collection
    {
        $query = OpdMaster::query();

        if ($id) {
            $query->where('id', $id);
        } elseif ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('singkatan', 'like', '%' . $search . '%');
            });
        }

        return $query->orderBy('name')
            ->limit(10)
            ->get()
            ->map(function (OpdMaster $o) {
                return [
                    'id' => $o->id,
                    'name' => $o->name,
                    'singkatan' => $o->singkatan,
                    'logo_url' => $o->logo_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($o->singkatan) . '&color=7F9CF5&background=EBF4FF',
                    'query' => $o->name . ' ' . $o->singkatan,
                ];
            });
    }

    public function createOpd(array $data, ?\Illuminate\Http\UploadedFile $logo = null): OpdMaster
    {
        $opd = OpdMaster::create([
            'name' => $data['name'],
            'singkatan' => $data['singkatan'],
            'address_opd' => $data['address_opd'] ?? null,
            'catatan' => $data['catatan'] ?? null,
        ]);

        if ($logo) {
            $path = $this->processAndStoreLogo($logo);
            $opd->logo_opd = $path;
            $opd->save();
        }

        return $opd;
    }

    public function updateOpd(OpdMaster $opd, array $data, ?\Illuminate\Http\UploadedFile $logo = null): OpdMaster
    {
        $opd->name = $data['name'];
        $opd->singkatan = $data['singkatan'];
        $opd->address_opd = $data['address_opd'] ?? $opd->address_opd;
        $opd->catatan = $data['catatan'] ?? $opd->catatan;

        // Handle Logo Removal
        if (isset($data['remove_logo']) && $data['remove_logo'] == '1') {
            if ($opd->logo_opd) {
                Storage::disk('public')->delete($opd->logo_opd);
                $opd->logo_opd = null;
            }
        }

        if ($logo) {
            if ($opd->logo_opd) {
                Storage::disk('public')->delete($opd->logo_opd);
            }
            $path = $this->processAndStoreLogo($logo);
            $opd->logo_opd = $path;
        }

        $opd->save();
        return $opd;
    }

    protected function processAndStoreLogo(\Illuminate\Http\UploadedFile $file): string
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($ext, $allowed, true)) {
            throw new \InvalidArgumentException('Format gambar tidak didukung.');
        }

        $filename = Str::uuid()->toString() . '.' . $ext;
        $path = $file->storeAs('opd_logos', $filename, 'public');
        return $path;
    }
}
