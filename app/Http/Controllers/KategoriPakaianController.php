<?php

namespace App\Http\Controllers;

use App\Models\KategoriPakaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriPakaianController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $perPage = $request->query('per_page', 10);

        $kategoris = KategoriPakaian::when($q, function ($query, $q) {
            return $query->where('name', 'like', "%{$q}%")
                ->orWhere('keterangan', 'like', "%{$q}%");
        })->latest()->paginate($perPage);

        $stats = [
            'total' => KategoriPakaian::count(),
            'total_pakaian' => DB::table('pakaians')->count(),
        ];

        return view('kategori_pakaian.index', compact('kategoris', 'q', 'stats'));
    }

    public function create()
    {
        return view('kategori_pakaian.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        KategoriPakaian::create($validated);

        return redirect()->route('kategori-pakaian.index')->with('success', 'Kategori Pakaian berhasil ditambahkan');
    }

    public function edit($uuid)
    {
        $kategori = KategoriPakaian::where('uuid', $uuid)->firstOrFail();
        return view('kategori_pakaian.edit', compact('kategori'));
    }

    public function update(Request $request, $uuid)
    {
        $kategori = KategoriPakaian::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $kategori->update($validated);

        return redirect()->route('kategori-pakaian.index')->with('success', 'Kategori Pakaian berhasil diperbarui');
    }

    public function destroy($uuid)
    {
        $kategori = KategoriPakaian::where('uuid', $uuid)->firstOrFail();
        $kategori->delete();

        return redirect()->route('kategori-pakaian.index')->with('success', 'Kategori Pakaian berhasil dihapus');
    }

    public function suggest(Request $request)
    {
        $q = (string) $request->query('q', '');

        $suggestions = KategoriPakaian::select('id', 'uuid', 'name')
            ->when($q, function ($query, $q) {
                return $query->where('name', 'like', "%{$q}%");
            })
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'uuid' => $item->uuid,
                    'name' => $item->name,
                ];
            });

        return response()->json(['data' => $suggestions]);
    }
}
