<?php

namespace App\Http\Controllers;

use App\Models\OpdMaster;
use App\Services\OpdMastersService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OpdMasterController extends Controller
{
    public function index(Request $request, OpdMastersService $service)
    {
        $q = (string) $request->query('q', '');
        $perPage = (int) $request->query('per_page', 10);
        $perPage = in_array($perPage, [10, 20, 50, 100], true) ? $perPage : 10;

        $opds = $service->listOpds($q ?: null, $perPage);
        $stats = $service->getStats();

        return view('opd.index', compact('opds', 'q', 'stats'));
    }

    public function create()
    {
        return view('opd.create');
    }

    public function store(Request $request, OpdMastersService $service): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'singkatan' => ['required', 'string', 'max:50'],
            'address_opd' => ['nullable', 'string'],
            'catatan' => ['nullable', 'string'],
            'logo_opd' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:800'],
        ]);

        try {
            $service->createOpd($validated, $request->file('logo_opd'));
            return redirect()->route('opd.index')->with('success', 'OPD Master berhasil ditambahkan');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(OpdMaster $opd)
    {
        return view('opd.edit', compact('opd'));
    }

    public function update(Request $request, OpdMastersService $service, OpdMaster $opd): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'singkatan' => ['required', 'string', 'max:50'],
            'address_opd' => ['nullable', 'string'],
            'catatan' => ['nullable', 'string'],
            'logo_opd' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:800'],
            'remove_logo' => ['nullable', 'string', 'in:0,1'],
        ]);

        try {
            $service->updateOpd($opd, $validated, $request->file('logo_opd'));
            return redirect()->route('opd.index')->with('success', 'OPD Master berhasil diperbarui');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(OpdMaster $opd): RedirectResponse
    {
        try {
            if ($opd->logo_opd) {
                Storage::disk('public')->delete($opd->logo_opd);
            }
            $opd->delete();
            return redirect()->route('opd.index')->with('success', 'OPD Master berhasil dihapus');
        } catch (\Throwable $e) {
            return redirect()->route('opd.index')->with('error', 'Gagal menghapus OPD: ' . $e->getMessage());
        }
    }

    public function suggest(Request $request, OpdMastersService $service)
    {
        $q = (string) $request->query('q', '');
        $id = $request->query('id');
        return response()->json(['data' => $service->suggestOpds($q ?: null, $id ? (int) $id : null)]);
    }
}
