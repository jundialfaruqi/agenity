<?php

namespace App\Http\Controllers;

use App\Models\Pakaian;
use App\Models\KategoriPakaian;
use Illuminate\Http\Request;

class PakaianController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $perPage = $request->query('per_page', 10);

        $pakaians = Pakaian::with('kategoriPakaian')
            ->when($q, function ($query, $q) {
                return $query->where('contoh_pakaian', 'like', "%{$q}%")
                    ->orWhereHas('kategoriPakaian', function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%");
                    });
            })->latest()->paginate($perPage);

        $stats = [
            'total' => Pakaian::count(),
            'total_kategori' => KategoriPakaian::count(),
        ];

        return view('pakaian.index', compact('pakaians', 'q', 'stats'));
    }

    public function create()
    {
        $kategoris = KategoriPakaian::orderBy('name')->get();
        return view('pakaian.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_pakaian_id' => 'required|exists:kategori_pakaians,id',
            'contoh_pakaian' => 'required|string|max:255',
        ]);

        Pakaian::create($validated);

        return redirect()->route('pakaian.index')->with('success', 'Pakaian berhasil ditambahkan');
    }

    public function edit($uuid)
    {
        $pakaian = Pakaian::where('uuid', $uuid)->firstOrFail();
        $kategoris = KategoriPakaian::orderBy('name')->get();
        return view('pakaian.edit', compact('pakaian', 'kategoris'));
    }

    public function update(Request $request, $uuid)
    {
        $pakaian = Pakaian::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'kategori_pakaian_id' => 'required|exists:kategori_pakaians,id',
            'contoh_pakaian' => 'required|string|max:255',
        ]);

        $pakaian->update($validated);

        return redirect()->route('pakaian.index')->with('success', 'Pakaian berhasil diperbarui');
    }

    public function destroy($uuid)
    {
        $pakaian = Pakaian::where('uuid', $uuid)->firstOrFail();
        $pakaian->delete();

        return redirect()->route('pakaian.index')->with('success', 'Pakaian berhasil dihapus');
    }

    public function suggest(Request $request)
    {
        $q = (string) $request->query('q', '');

        $suggestions = Pakaian::select('id', 'uuid', 'contoh_pakaian', 'kategori_pakaian_id')
            ->with('kategoriPakaian:id,name')
            ->when($q, function ($query, $q) {
                return $query->where('contoh_pakaian', 'like', "%{$q}%")
                    ->orWhereHas('kategoriPakaian', function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%");
                    });
            })
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'uuid' => $item->uuid,
                    'name' => $item->contoh_pakaian . ' (' . ($item->kategoriPakaian->name ?? '-') . ')',
                ];
            });

        return response()->json(['data' => $suggestions]);
    }
}
