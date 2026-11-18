@extends('layouts.app')

@section('title', 'Edit Perlengkapan — Observatorium Langit Gelap')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('equipments.index') }}" class="text-xs text-indigo-400 hover:underline">← Kembali ke Daftar Perlengkapan</a>
        <h1 class="text-2xl font-bold text-white mt-1">Edit Perlengkapan: {{ $equipment->code }}</h1>
    </div>

    <form action="{{ route('equipments.update', $equipment) }}" method="POST" class="bg-slate-900 border border-slate-800 rounded-xl p-6 space-y-4">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-form-input label="Kode Alat" name="code" :value="$equipment->code" required />
            <x-form-input label="Tipe Alat" name="type" :value="$equipment->type" required />
            <div class="sm:col-span-2">
                <x-form-input label="Nama Perlengkapan" name="name" :value="$equipment->name" required />
            </div>
            <div class="sm:col-span-2">
                <x-form-input label="Spesifikasi Teknis" name="specifications" :value="$equipment->specifications" />
            </div>
        </div>
        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('equipments.index') }}" class="rounded-lg bg-slate-800 px-4 py-2 text-sm text-slate-300">Batal</a>
            <button type="submit" class="rounded-lg bg-indigo-600 hover:bg-indigo-500 px-5 py-2 text-sm font-semibold text-white">Perbarui</button>
        </div>
    </form>
</div>
@endsection