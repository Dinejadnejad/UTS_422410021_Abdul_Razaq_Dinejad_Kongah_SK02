@extends('layouts.app')

@section('title', 'Tambah Sesi Pengamatan — Observatorium Langit Gelap')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('observation-sessions.index') }}" class="text-xs text-indigo-400 hover:underline">← Kembali ke Daftar Sesi</a>
        <h1 class="text-2xl font-bold text-white mt-1">Tambah Sesi Pengamatan Baru</h1>
    </div>

    <form action="{{ route('observation-sessions.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Bagian 1: Data Utama Sesi --}}
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 space-y-4">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-indigo-400">1. Informasi Utama Sesi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form-input label="Kode Sesi" name="session_code" placeholder="Contoh: OBS-2026-002" required />
                <x-form-input label="Nama Sesi Pengamatan" name="session_name" placeholder="Contoh: Pemotretan Galaksi Andromeda" required />

                <div>
                    <label for="target_object_id" class="block text-xs font-medium text-slate-300 mb-1.5">
                        Objek Sasaran <span class="text-rose-400">*</span>
                    </label>
                    <select name="target_object_id" id="target_object_id" required
                            class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3.5 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                        <option value="">-- Pilih Objek Langit --</option>
                        @foreach ($targetObjects as $obj)
                            <option value="{{ $obj->id }}" @selected(old('target_object_id') == $obj->id)>
                                {{ $obj->code }} — {{ $obj->name }} ({{ $obj->catalog_number }})
                            </option>
                        @endforeach
                    </select>
                    @error('target_object_id') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
                </div>

                <x-form-input label="Tanggal Pengamatan" name="observation_date" type="date" required />

                <div>
                    <label for="weather_condition" class="block text-xs font-medium text-slate-300 mb-1.5">
                        Kondisi Cuaca <span class="text-rose-400">*</span>
                    </label>
                    <select name="weather_condition" id="weather_condition" required
                            class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3.5 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                        @foreach (['Cerah', 'Berawan Sebagian', 'Berkabut', 'Mendung'] as $weather)
                            <option value="{{ $weather }}" @selected(old('weather_condition') === $weather)>{{ $weather }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label for="notes" class="block text-xs font-medium text-slate-300 mb-1.5">Catatan Pengamatan</label>
                <textarea name="notes" id="notes" rows="2"
                          class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3.5 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">{{ old('notes') }}</textarea>
            </div>
        </div>

        {{-- Bagian 2: Detail Lokasi Pengamatan (Relasi 1-to-1) --}}
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 space-y-4">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-indigo-400">2. Detail Lokasi Pengamatan (1-to-1)</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <x-form-input label="Nama Lokasi Observasi" name="location_name" placeholder="Contoh: Bukit Pengamatan Timau, Kupang" required />
                </div>
                <x-form-input label="Garis Lintang (Latitude)" name="latitude" type="number" step="0.0000001" placeholder="-6.8247220" required />
                <x-form-input label="Garis Bujur (Longitude)" name="longitude" type="number" step="0.0000001" placeholder="107.6158330" required />
                <x-form-input label="Ketinggian (mdpl)" name="elevation_masl" type="number" placeholder="1310" required />
                <x-form-input label="Skala Bortle (1 - 9)" name="bortle_scale" type="number" min="1" max="9" placeholder="1 = Paling Gelap, 9 = Kota" required />
            </div>
        </div>

        {{-- Bagian 3: Pilihan Jamak Perlengkapan (Relasi Many-to-Many) --}}
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 space-y-4">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-indigo-400">3. Perlengkapan yang Digunakan (Pilihan Jamak)</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach ($equipments as $eq)
                    <label class="flex items-start gap-3 p-3 rounded-lg bg-slate-950 border border-slate-800 hover:border-indigo-500/50 cursor-pointer">
                        <input type="checkbox" name="equipments[]" value="{{ $eq->id }}"
                               @checked(in_array($eq->id, old('equipments', [])))
                               class="mt-1 rounded border-slate-700 bg-slate-900 text-indigo-600 focus:ring-indigo-500">
                        <div>
                            <div class="text-sm font-medium text-slate-200">{{ $eq->name }}</div>
                            <div class="text-xs text-slate-400">{{ $eq->code }} • {{ $eq->type }}</div>
                        </div>
                    </label>
                @endforeach
            </div>
            @error('equipments') <p class="text-xs text-rose-400">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('observation-sessions.index') }}"
               class="rounded-lg bg-slate-800 hover:bg-slate-700 px-5 py-2.5 text-sm font-medium text-slate-300 transition">
                Batal
            </a>
            <button type="submit"
                    class="rounded-lg bg-indigo-600 hover:bg-indigo-500 px-6 py-2.5 text-sm font-semibold text-white transition">
                Simpan Sesi Pengamatan
            </button>
        </div>
    </form>
</div>
@endsection