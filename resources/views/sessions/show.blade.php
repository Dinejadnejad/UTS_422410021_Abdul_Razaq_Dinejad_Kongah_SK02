@extends('layouts.app')

@section('title', 'Detail Sesi ' . $observationSession->session_code)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('observation-sessions.index') }}" class="text-xs text-indigo-400 hover:underline">← Kembali ke Daftar Sesi</a>
            <h1 class="text-2xl font-bold text-white mt-1">{{ $observationSession->session_name }}</h1>
            <p class="text-sm font-mono text-indigo-400">{{ $observationSession->session_code }}</p>
        </div>
        <a href="{{ route('observation-sessions.edit', $observationSession) }}"
           class="rounded-lg bg-amber-600 hover:bg-amber-500 px-4 py-2 text-sm font-semibold text-white transition">
            Edit Sesi
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Kartu Informasi Utama & Objek Sasaran --}}
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 space-y-3">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-indigo-400">Informasi Sesi & Objek Sasaran</h2>
            <div class="text-sm space-y-2">
                <p><span class="text-slate-400">Tanggal:</span> <strong class="text-white">{{ $observationSession->observation_date->format('d F Y') }}</strong></p>
                <p><span class="text-slate-400">Cuaca:</span> <strong class="text-white">{{ $observationSession->weather_condition }}</strong></p>
                <p><span class="text-slate-400">Objek Sasaran:</span> <strong class="text-white">{{ $observationSession->targetObject->name }} ({{ $observationSession->targetObject->catalog_number }})</strong></p>
                <p><span class="text-slate-400">Kategori Objek:</span> <span class="text-slate-200">{{ $observationSession->targetObject->category }}</span></p>
                <p><span class="text-slate-400">Catatan:</span> <span class="text-slate-300">{{ $observationSession->notes ?: '-' }}</span></p>
            </div>
        </div>

        {{-- Kartu Detail Lokasi (1-to-1) --}}
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 space-y-3">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-indigo-400">Detail Lokasi Pengamatan (1-to-1)</h2>
            @if ($observationSession->location)
                <div class="text-sm space-y-2">
                    <p><span class="text-slate-400">Lokasi:</span> <strong class="text-white">{{ $observationSession->location->location_name }}</strong></p>
                    <p><span class="text-slate-400">Koordinat:</span> <span class="font-mono text-slate-200">{{ $observationSession->location->latitude }}, {{ $observationSession->location->longitude }}</span></p>
                    <p><span class="text-slate-400">Elevasi:</span> <span class="text-slate-200">{{ $observationSession->location->elevation_masl }} mdpl</span></p>
                    <div class="pt-1">
                        <x-bortle-badge :scale="$observationSession->location->bortle_scale" />
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Kartu Perlengkapan (Many-to-Many) --}}
    <div class="bg-slate-900 border border-slate-800 rounded-xl p-6">
        <h2 class="text-xs font-semibold uppercase tracking-wider text-indigo-400 mb-4">Perlengkapan yang Digunakan ({{ $observationSession->equipments->count() }} Unit)</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach ($observationSession->equipments as $eq)
                <div class="p-3.5 rounded-lg bg-slate-950 border border-slate-800">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-white text-sm">{{ $eq->name }}</span>
                        <span class="text-xs font-mono text-indigo-400">{{ $eq->code }}</span>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">{{ $eq->type }} — {{ $eq->specifications ?: 'Tanpa spesifikasi tambahan' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection