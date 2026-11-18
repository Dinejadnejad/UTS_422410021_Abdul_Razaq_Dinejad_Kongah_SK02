@extends('layouts.app')

@section('title', 'Edit Sesi Pengamatan — Observatorium Langit Gelap')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('observation-sessions.index') }}" class="text-xs text-indigo-400 hover:underline">← Kembali ke Daftar Sesi</a>
        <h1 class="text-2xl font-bold text-white mt-1">Edit Sesi: {{ $observationSession->session_code }}</h1>
    </div>

    <form action="{{ route('observation-sessions.update', $observationSession) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 space-y-4">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-indigo-400">1. Informasi Utama Sesi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form-input label="Kode Sesi" name="session_code" :value="$observationSession->session_code" required />
                <x-form-input label="Nama Sesi Pengamatan" name="session_name" :value="$observationSession->session_name" required />

                <div>
                    <label for="target_object_id" class="block text-xs font-medium text-slate-300 mb-1.5">
                        Objek Sasaran <span class="text-rose-400">*</span>
                    </label>
                    <select name="target_object_id" id="target_object_id" required
                            class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3.5 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                        @foreach ($targetObjects as $obj)
                            <option value="{{ $obj->id }}" @selected(old('target_object_id', $observationSession->target_object_id) == $obj->id)>
                                {{ $obj->code }} — {{ $obj->name }} ({{ $obj->catalog_number }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <x-form-input label="Tanggal Pengamatan" name="observation_date" type="date"
                              :value="$observationSession->observation_date->format('Y-m-d')" required />

                <div>
                    <label for="weather_condition" class="block text-xs font-medium text-slate-300 mb-1.5">
                        Kondisi Cuaca <span class="text-rose-400">*</span>
                    </label>
                    <select name="weather_condition" id="weather_condition" required
                            class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3.5 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                        @foreach (['Cerah', 'Berawan Sebagian', 'Berkabut', 'Mendung'] as $weather)
                            <option value="{{ $weather }}" @selected(old('weather_condition', $observationSession->weather_condition) === $weather)>
                                {{ $weather }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label for="notes" class="block text-xs font-medium text-slate-300 mb-1.5">Catatan Pengamatan</label>
                <textarea name="notes" id="notes" rows="2"
                          class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3.5 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">{{ old('notes', $observationSession->notes) }}</textarea>
            </div>
        </div>

        <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 space-y-4">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-indigo-400">2. Detail Lokasi Pengamatan (1-to-1)</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <x-form-input label="Nama Lokasi Observasi" name="location_name"
                                  :value="$observationSession->location?->location_name" required />
                </div>
                <x-form-input label="Garis Lintang (Latitude)" name="latitude" type="number" step="0.0000001"
                              :value="$observationSession->location?->latitude" required />
                <x-form-input label="Garis Bujur (Longitude)" name="longitude" type="number" step="0.0000001"
                              :value="$observationSession->location?->longitude" required />
                <x-form-input label="Ketinggian (mdpl)" name="elevation_masl" type="number"
                              :value="$observationSession->location?->elevation_masl" required />
                <x-form-input label="Skala Bortle (1 - 9)" name="bortle_scale" type="number" min="1" max="9"
                              :value="$observationSession->location?->bortle_scale" required />
            </div>
        </div>

        @php
            $selectedEquipments = old('equipments', $observationSession->equipments->pluck('id')->toArray());
        @endphp
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 space-y-4">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-indigo-400">3. Perlengkapan yang Digunakan (Pilihan Jamak)</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach ($equipments as $eq)
                    <label class="flex items-start gap-3 p-3 rounded-lg bg-slate-950 border border-slate-800 hover:border-indigo-500/50 cursor-pointer">
                        <input type="checkbox" name="equipments[]" value="{{ $eq->id }}"
                               @checked(in_array($eq->id, $selectedEquipments))
                               class="mt-1 rounded border-slate-700 bg-slate-900 text-indigo-600 focus:ring-indigo-500">
                        <div>
                            <div class="text-sm font-medium text-slate-200">{{ $eq->name }}</div>
                            <div class="text-xs text-slate-400">{{ $eq->code }} • {{ $eq->type }}</div>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('observation-sessions.index') }}"
               class="rounded-lg bg-slate-800 hover:bg-slate-700 px-5 py-2.5 text-sm font-medium text-slate-300 transition">
                Batal
            </a>
            <button type="submit"
                    class="rounded-lg bg-indigo-600 hover:bg-indigo-500 px-6 py-2.5 text-sm font-semibold text-white transition">
                Perbarui Sesi
            </button>
        </div>
    </form>
</div>
@endsection