<x-layout title="Edit Agenda">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Edit Agenda</h1>
            <p class="text-sm text-base-content/60 mt-1">Perbarui data agenda kegiatan</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="{{ route('dashboard.index') }}">{{ $appSetting->app_name ?? config('app.name') }}</a></li>
                <li><a href="{{ route('agenda.index') }}">Agenda</a></li>
                <li><span class="text-base-content">Edit</span></li>
            </ul>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm">
        <div class="card-body">
            <form action="{{ route('agenda.update', $agenda->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="label"><span class="label-text font-bold mb-2">Judul Agenda</span></label>
                        <input name="title" type="text" value="{{ old('title', $agenda->title) }}"
                            class="input input-bordered w-full" placeholder="Masukkan judul kegiatan/rapat" required>
                        @error('title')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="label"><span class="label-text font-bold mb-2">Jenis Agenda</span></label>
                        <input name="jenis_agenda" type="text"
                            value="{{ old('jenis_agenda', $agenda->jenis_agenda) }}" class="input input-bordered w-full"
                            placeholder="Contoh: Rapat Koordinasi, Seminar, dsb" required>
                        @error('jenis_agenda')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="label"><span class="label-text font-bold mb-2">OPD Penyelenggara</span></label>
                        <select name="master_opd_id" class="select select-bordered w-full" required>
                            <option value="">Pilih OPD...</option>
                            @foreach ($opds as $opd)
                                <option value="{{ $opd->id }}" @selected(old('master_opd_id', $agenda->master_opd_id) == $opd->id)>{{ $opd->singkatan }} -
                                    {{ $opd->name }}</option>
                            @endforeach
                        </select>
                        @error('master_opd_id')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="label"><span class="label-text font-bold mb-2">Visibility</span></label>
                        <select name="visibility" class="select select-bordered w-full" required>
                            <option value="public" @selected(old('visibility', $agenda->visibility) === 'public')>Public (Tampil di dashboard public)
                            </option>
                            <option value="private" @selected(old('visibility', $agenda->visibility) === 'private')>Private (Hanya via link)</option>
                        </select>
                    </div>

                    <div>
                        <label class="label"><span class="label-text font-bold mb-2">Mode</span></label>
                        <select name="mode" class="select select-bordered w-full" required>
                            <option value="offline" @selected(old('mode', $agenda->mode) === 'offline')>Offline (Tatap Muka)</option>
                            <option value="online" @selected(old('mode', $agenda->mode) === 'online')>Online (Daring)</option>
                            <option value="hybrid" @selected(old('mode', $agenda->mode) === 'hybrid')>Hybrid (Keduanya)</option>
                        </select>
                    </div>

                    <div>
                        <label class="label"><span class="label-text font-bold mb-2">Tanggal Kegiatan</span></label>
                        <input name="date" type="date" value="{{ old('date', $agenda->date) }}"
                            class="input input-bordered w-full" required>
                        @error('date')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label"><span class="label-text font-bold mb-2">Jam Mulai</span></label>
                            <input name="start_time" type="time"
                                value="{{ old('start_time', \Carbon\Carbon::parse($agenda->start_time)->format('H:i')) }}"
                                class="input input-bordered w-full" required>
                        </div>
                        <div>
                            <label class="label"><span class="label-text font-bold mb-2">Jam Selesai</span></label>
                            <input name="end_time" type="time"
                                value="{{ old('end_time', \Carbon\Carbon::parse($agenda->end_time)->format('H:i')) }}"
                                class="input input-bordered w-full" required>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="label"><span class="label-text font-bold mb-2">Lokasi / Ruangan</span></label>
                        <input name="location" type="text" value="{{ old('location', $agenda->location) }}"
                            class="input input-bordered w-full" placeholder="Contoh: Ruang Rapat Lt. 3">
                        @error('location')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="label"><span class="label-text font-bold mb-2">Link Paparan</span></label>
                        <input name="link_paparan" type="url"
                            value="{{ old('link_paparan', $agenda->link_paparan) }}"
                            class="input input-bordered w-full" placeholder="https://...">
                    </div>

                    <div>
                        <label class="label"><span class="label-text font-bold mb-2">Link Zoom / Meeting</span></label>
                        <input name="link_zoom" type="url" value="{{ old('link_zoom', $agenda->link_zoom) }}"
                            class="input input-bordered w-full" placeholder="https://...">
                    </div>

                    <div>
                        <label class="label"><span class="label-text font-bold mb-2">Status Publikasi</span></label>
                        <select name="status" class="select select-bordered w-full" required>
                            <option value="draft" @selected(old('status', $agenda->status) === 'draft')>Draft</option>
                            <option value="active" @selected(old('status', $agenda->status) === 'active')>Published / Active</option>
                            <option value="finished" @selected(old('status', $agenda->status) === 'finished')>Finished</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="label"><span class="label-text font-bold mb-2">Catatan Tambahan</span></label>
                        <textarea name="catatan" class="textarea textarea-bordered w-full h-24"
                            placeholder="Masukkan informasi tambahan jika ada">{{ old('catatan', $agenda->catatan) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8">
                    <a href="{{ route('agenda.index') }}" class="btn btn-base">Batal</a>
                    <button type="submit" class="btn btn-secondary px-8">Perbarui Agenda</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
