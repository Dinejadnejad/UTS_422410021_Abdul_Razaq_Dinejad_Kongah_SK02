@extends('layouts.app')

@section('title', 'Daftar Objek Sasaran — Observatorium Langit Gelap')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Objek Sasaran Astronomi</h1>
        <p class="text-sm text-slate-400">Kelola kategori objek langit (Nebula, Galaksi, Planet, Gugus Bintang).</p>
    </div>
    <a href="{{ route('target-objects.create') }}"
       class="inline-flex items-center justify-center rounded-lg bg-indigo-600 hover:bg-indigo-500 px-4 py-2.5 text-sm font-semibold text-white transition">
        + Tambah Objek Sasaran
    </a>
</div>

<form method="GET" action="{{ route('target-objects.index') }}" class="bg-slate-900 border border-slate-800 rounded-xl p-4 mb-6 flex gap-3">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cari kode, nama objek, atau nomor katalog (mis. M42)..."
           class="flex-1 rounded-lg bg-slate-950 border border-slate-700 px-3.5 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
    <button type="submit" class="rounded-lg bg-indigo-600 hover:bg-indigo-500 px-4 py-2 text-sm font-medium text-white">Cari</button>
    <a href="{{ route('target-objects.index') }}" class="rounded-lg bg-slate-800 hover:bg-slate-700 px-3.5 py-2 text-sm text-slate-300">Reset</a>
</form>

<div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-950/70 text-xs uppercase text-slate-400 border-b border-slate-800">
                <tr>
                    <th class="px-4 py-3.5">Kode</th>
                    <th class="px-4 py-3.5">Nama Objek & Katalog</th>
                    <th class="px-4 py-3.5">Kategori</th>
                    <th class="px-4 py-3.5">Deskripsi</th>
                    <th class="px-4 py-3.5">Jumlah Sesi</th>
                    <th class="px-4 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse ($targetObjects as $obj)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="px-4 py-4 font-mono text-xs text-indigo-400">{{ $obj->code }}</td>
                        <td class="px-4 py-4">
                            <div class="font-semibold text-white">{{ $obj->name }}</div>
                            <div class="text-xs text-slate-400">Katalog: {{ $obj->catalog_number }}</div>
                        </td>
                        <td class="px-4 py-4 text-slate-300">{{ $obj->category }}</td>
                        <td class="px-4 py-4 text-slate-400 text-xs max-w-xs">{{ $obj->description ?: '-' }}</td>
                        <td class="px-4 py-4 text-slate-300">{{ $obj->observation_sessions_count }} sesi</td>
                        <td class="px-4 py-4 text-right whitespace-nowrap space-x-2">
                            <a href="{{ route('target-objects.edit', $obj) }}" class="text-amber-400 hover:text-amber-300 text-xs font-medium">Edit</a>
                            <form action="{{ route('target-objects.destroy', $obj) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Hapus objek sasaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-400 hover:text-rose-300 text-xs font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-400">Belum ada data objek sasaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-t border-slate-800">{{ $targetObjects->links() }}</div>
</div>
@endsection