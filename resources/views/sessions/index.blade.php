@extends('layouts.app')

@section('title', 'Daftar Sesi Pengamatan — Observatorium Langit Gelap')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Sesi Pengamatan Astronomi</h1>
        <p class="text-sm text-slate-400">Kelola jadwal, objek sasaran, titik koordinat lokasi, dan perlengkapan observasi.</p>
    </div>
    <a href="{{ route('observation-sessions.create') }}"
       class="inline-flex items-center justify-center rounded-lg bg-indigo-600 hover:bg-indigo-500 px-4 py-2.5 text-sm font-semibold text-white transition">
        + Tambah Sesi Baru
    </a>
</div>

{{-- Form Pencarian & Filter (Syarat Soal No. 6) --}}
<form method="GET" action="{{ route('observation-sessions.index') }}"
      class="bg-slate-900 border border-slate-800 rounded-xl p-4 mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
    <div>
        <label class="block text-xs text-slate-400 mb-1">Pencarian</label>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Kode, nama sesi, atau lokasi..."
               class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
    </div>

    <div>
        <label class="block text-xs text-slate-400 mb-1">Filter Objek Sasaran</label>
        <select name="target_object_id"
                class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
            <option value="">Semua Objek Langit</option>
            @foreach ($targetObjects as $obj)
                <option value="{{ $obj->id }}" @selected(request('target_object_id') == $obj->id)>
                    {{ $obj->code }} — {{ $obj->name }} ({{ $obj->catalog_number }})
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-xs text-slate-400 mb-1">Filter Kondisi Cuaca</label>
        <select name="weather_condition"
                class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
            <option value="">Semua Cuaca</option>
            @foreach (['Cerah', 'Berawan Sebagian', 'Berkabut', 'Mendung'] as $weather)
                <option value="{{ $weather }}" @selected(request('weather_condition') === $weather)>
                    {{ $weather }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="flex items-end gap-2">
        <button type="submit"
                class="flex-1 rounded-lg bg-indigo-600 hover:bg-indigo-500 px-4 py-2 text-sm font-medium text-white transition">
            Terapkan
        </button>
        <a href="{{ route('observation-sessions.index') }}"
           class="rounded-lg bg-slate-800 hover:bg-slate-700 px-3 py-2 text-sm text-slate-300 transition">
            Reset
        </a>
    </div>
</form>

{{-- Tabel Data Utama + Relasi --}}
<div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-950/70 text-xs uppercase text-slate-400 border-b border-slate-800">
                <tr>
                    <th class="px-4 py-3.5">Kode & Nama Sesi</th>
                    <th class="px-4 py-3.5">Objek Sasaran</th>
                    <th class="px-4 py-3.5">Lokasi (1-to-1)</th>
                    <th class="px-4 py-3.5">Perlengkapan (M-to-M)</th>
                    <th class="px-4 py-3.5">Tanggal & Cuaca</th>
                    <th class="px-4 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse ($sessions as $session)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="px-4 py-4">
                            <span class="text-xs font-mono text-indigo-400">{{ $session->session_code }}</span>
                            <div class="font-semibold text-white">{{ $session->session_name }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-slate-200">{{ $session->targetObject->name }}</div>
                            <div class="text-xs text-slate-400">{{ $session->targetObject->catalog_number }} • {{ $session->targetObject->category }}</div>
                        </td>
                        <td class="px-4 py-4">
                            @if ($session->location)
                                <div class="text-slate-200 mb-1">{{ $session->location->location_name }}</div>
                                {{-- Memanggil Blade Component Bortle Badge --}}
                                <x-bortle-badge :scale="$session->location->bortle_scale" />
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach ($session->equipments as $eq)
                                    <span class="px-2 py-0.5 rounded bg-slate-800 border border-slate-700 text-xs text-slate-300">
                                        {{ $eq->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-slate-200">{{ $session->observation_date->format('d M Y') }}</div>
                            <div class="text-xs text-slate-400">{{ $session->weather_condition }}</div>
                        </td>
                        <td class="px-4 py-4 text-right whitespace-nowrap space-x-2">
                            <a href="{{ route('observation-sessions.show', $session) }}"
                               class="text-sky-400 hover:text-sky-300 text-xs font-medium">Detail</a>
                            <a href="{{ route('observation-sessions.edit', $session) }}"
                               class="text-amber-400 hover:text-amber-300 text-xs font-medium">Edit</a>
                            <form action="{{ route('observation-sessions.destroy', $session) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus sesi pengamatan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-400 hover:text-rose-300 text-xs font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                            Belum ada data sesi pengamatan yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-t border-slate-800">
        {{ $sessions->links() }}
    </div>
</div>
@endsection