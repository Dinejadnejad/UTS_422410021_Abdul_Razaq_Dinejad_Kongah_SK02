@extends('layouts.app')

@section('title', 'Daftar Perlengkapan — Observatorium Langit Gelap')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Perlengkapan Observatorium</h1>
        <p class="text-sm text-slate-400">Kelola instrumen teleskop, kamera astro, mount, dan filter optik.</p>
    </div>
    <a href="{{ route('equipments.create') }}"
       class="inline-flex items-center justify-center rounded-lg bg-indigo-600 hover:bg-indigo-500 px-4 py-2.5 text-sm font-semibold text-white transition">
        + Tambah Perlengkapan
    </a>
</div>

<form method="GET" action="{{ route('equipments.index') }}" class="bg-slate-900 border border-slate-800 rounded-xl p-4 mb-6 flex gap-3">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cari kode, nama perlengkapan, atau tipe alat..."
           class="flex-1 rounded-lg bg-slate-950 border border-slate-700 px-3.5 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
    <button type="submit" class="rounded-lg bg-indigo-600 hover:bg-indigo-500 px-4 py-2 text-sm font-medium text-white">Cari</button>
    <a href="{{ route('equipments.index') }}" class="rounded-lg bg-slate-800 hover:bg-slate-700 px-3.5 py-2 text-sm text-slate-300">Reset</a>
</form>

<div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-950/70 text-xs uppercase text-slate-400 border-b border-slate-800">
                <tr>
                    <th class="px-4 py-3.5">Kode</th>
                    <th class="px-4 py-3.5">Nama Perlengkapan</th>
                    <th class="px-4 py-3.5">Tipe</th>
                    <th class="px-4 py-3.5">Spesifikasi</th>
                    <th class="px-4 py-3.5">Dipakai</th>
                    <th class="px-4 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse ($equipments as $eq)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="px-4 py-4 font-mono text-xs text-indigo-400">{{ $eq->code }}</td>
                        <td class="px-4 py-4 font-semibold text-white">{{ $eq->name }}</td>
                        <td class="px-4 py-4 text-slate-300">{{ $eq->type }}</td>
                        <td class="px-4 py-4 text-slate-400 text-xs">{{ $eq->specifications ?: '-' }}</td>
                        <td class="px-4 py-4 text-slate-300">{{ $eq->observation_sessions_count }} sesi</td>
                        <td class="px-4 py-4 text-right whitespace-nowrap space-x-2">
                            <a href="{{ route('equipments.edit', $eq) }}" class="text-amber-400 hover:text-amber-300 text-xs font-medium">Edit</a>
                            <form action="{{ route('equipments.destroy', $eq) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Hapus perlengkapan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-400 hover:text-rose-300 text-xs font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-400">Belum ada data perlengkapan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-t border-slate-800">{{ $equipments->links() }}</div>
</div>
@endsection