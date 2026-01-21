<x-layout title="Edit Kategori Pakaian">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Edit Kategori Pakaian</h1>
            <p class="text-sm text-base-content/60 mt-1">Perbarui data kategori pakaian</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="{{ route('dashboard.index') }}">{{ $appSetting->app_name ?? config('app.name') }}</a></li>
                <li>Master Pakaian</li>
                <li><a href="{{ route('kategori-pakaian.index') }}">Kategori Pakaian</a></li>
                <li><span class="text-base-content">Edit</span></li>
            </ul>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('kategori-pakaian.update', $kategori->uuid) }}" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="label"><span class="label-text mb-2">Nama Kategori</span></label>
                        <input name="name" type="text" value="{{ old('name', $kategori->name) }}"
                            class="input input-bordered w-full" placeholder="Contoh: Pakaian Dinas Harian">
                        @error('name')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="label"><span class="label-text mb-2">Keterangan (opsional)</span></label>
                        <textarea name="keterangan" class="textarea textarea-bordered w-full" rows="3"
                            placeholder="Masukkan keterangan kategori pakaian">{{ old('keterangan', $kategori->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('kategori-pakaian.index') }}" class="btn">Batal</a>
                    <button type="submit" class="btn btn-secondary">
                        <span class="btn-text">Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>