<x-layout title="Create Pakaian">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Create Pakaian</h1>
            <p class="text-sm text-base-content/60 mt-1">Tambah data pakaian baru</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="{{ route('dashboard.index') }}">{{ $appSetting->app_name ?? config('app.name') }}</a></li>
                <li>Master Pakaian</li>
                <li><a href="{{ route('pakaian.index') }}">Pakaian</a></li>
                <li><span class="text-base-content">Create</span></li>
            </ul>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('pakaian.store') }}" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="label"><span class="label-text mb-2">Kategori Pakaian</span></label>
                        <select name="kategori_pakaian_id" class="select select-bordered w-full">
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" @selected(old('kategori_pakaian_id') == $kategori->id)>
                                    {{ $kategori->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_pakaian_id')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="label"><span class="label-text mb-2">Contoh Pakaian</span></label>
                        <input name="contoh_pakaian" type="text" value="{{ old('contoh_pakaian') }}"
                            class="input input-bordered w-full" placeholder="Contoh: Kemeja Putih Lengan Panjang">
                        @error('contoh_pakaian')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('pakaian.index') }}" class="btn">Batal</a>
                    <button type="submit" class="btn btn-secondary">
                        <span class="btn-text">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>