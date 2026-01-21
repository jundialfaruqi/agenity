<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use App\Models\Pakaian;
use App\Models\Agenda;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DokumentasiController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $q = $request->query('q');
        $date = $request->query('date');
        $month = $request->query('month');
        $year = $request->query('year');
        $day = $request->query('day');
        $pakaian_id = $request->query('pakaian_id');
        $perPage = $request->query('per_page', 10);

        $dokumentasis = Dokumentasi::with(['pakaian', 'agenda', 'event'])
            ->when(!$user->hasRole('super-admin'), function ($query) use ($user) {
                return $query->where('opd_master_id', $user->opd_master_id);
            })
            ->when($q, function ($query, $q) {
                return $query->where(function ($query) use ($q) {
                    $query->where('judul', 'like', "%{$q}%")
                        ->orWhere('keterangan', 'like', "%{$q}%")
                        ->orWhere('date', 'like', "%{$q}%")
                        ->orWhereHas('pakaian', function ($query) use ($q) {
                            $query->where('contoh_pakaian', 'like', "%{$q}%");
                        });
                });
            })
            ->when($date, function ($query, $date) {
                return $query->whereDate('date', $date);
            })
            ->when($month, function ($query, $month) {
                return $query->whereMonth('date', $month);
            })
            ->when($year, function ($query, $year) {
                return $query->whereYear('date', $year);
            })
            ->when($day, function ($query, $day) {
                return $query->whereRaw('DAYNAME(date) = ?', [$day]);
            })
            ->when($pakaian_id, function ($query, $pakaian_id) {
                return $query->where('pakaian_id', $pakaian_id);
            })
            ->latest()
            ->paginate($perPage);

        $stats = [
            'total' => Dokumentasi::count(),
            'total_pakaian' => Pakaian::count(),
        ];

        $pakaians = Pakaian::with('kategoriPakaian')->get();
        $agendas = Agenda::orderBy('date', 'desc')->get();
        $events = Event::orderBy('date', 'desc')->get();

        return view('dokumentasi.index', compact('dokumentasis', 'q', 'stats', 'pakaians', 'agendas', 'events'));
    }

    public function create()
    {
        $pakaians = Pakaian::with('kategoriPakaian')->get();
        $agendas = Agenda::orderBy('date', 'desc')->get();
        $events = Event::orderBy('date', 'desc')->get();

        return view('dokumentasi.create', compact('pakaians', 'agendas', 'events'));
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $validated = $request->validate([
            'date' => 'required|date',
            'pakaian_id' => 'required|exists:pakaians,id',
            'agenda_id' => 'nullable|exists:agendas,id',
            'event_id' => 'nullable|exists:events,id',
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'link_dokumentasi' => 'nullable|url',
        ]);

        $validated['user_id'] = $user->id;
        $validated['opd_master_id'] = $user->opd_master_id;

        Dokumentasi::create($validated);

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil ditambahkan');
    }

    public function edit($uuid)
    {
        $dokumentasi = Dokumentasi::where('uuid', $uuid)->firstOrFail();
        $pakaians = Pakaian::with('kategoriPakaian')->get();
        $agendas = Agenda::orderBy('date', 'desc')->get();
        $events = Event::orderBy('date', 'desc')->get();

        return view('dokumentasi.edit', compact('dokumentasi', 'pakaians', 'agendas', 'events'));
    }

    public function update(Request $request, $uuid)
    {
        $dokumentasi = Dokumentasi::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'date' => 'required|date',
            'pakaian_id' => 'required|exists:pakaians,id',
            'agenda_id' => 'nullable|exists:agendas,id',
            'event_id' => 'nullable|exists:events,id',
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'link_dokumentasi' => 'nullable|url',
        ]);

        $dokumentasi->update($validated);

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil diperbarui');
    }

    public function destroy($uuid)
    {
        $dokumentasi = Dokumentasi::where('uuid', $uuid)->firstOrFail();
        $dokumentasi->delete();

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil dihapus');
    }

    public function suggest(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $q = (string) $request->query('q', '');

        $suggestions = Dokumentasi::with(['pakaian'])
            ->select('id', 'uuid', 'judul', 'date', 'pakaian_id')
            ->when(!$user->hasRole('super-admin'), function ($query) use ($user) {
                return $query->where('opd_master_id', $user->opd_master_id);
            })
            ->when($q, function ($query, $q) {
                return $query->where(function ($query) use ($q) {
                    $query->where('judul', 'like', "%{$q}%")
                        ->orWhere('date', 'like', "%{$q}%")
                        ->orWhereHas('pakaian', function ($query) use ($q) {
                            $query->where('contoh_pakaian', 'like', "%{$q}%");
                        });
                });
            })
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'uuid' => $item->uuid,
                    'name' => $item->judul,
                    'date' => \Carbon\Carbon::parse($item->date)->translatedFormat('d F Y'),
                    'pakaian' => $item->pakaian->contoh_pakaian ?? '-',
                ];
            });

        return response()->json(['data' => $suggestions]);
    }
}
