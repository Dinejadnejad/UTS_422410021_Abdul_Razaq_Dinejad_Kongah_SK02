@extends('layouts.app')

@section('title', 'Edit Objek Sasaran — Observatorium Langit Gelap')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('target-objects.index') }}" class="text-xs text-indigo-400 hover:underline">← Kembali ke Daftar Objek</a>
        <h1 class="text-2xl font-bold text-white mt-1">Edit Objek: {{ $targetObject->code }}</h1>
    </div>

    <form action="{{ route('target-objects.update', $targetObject) }}" method="POST" class="bg-slate-900 border border-slate-800 rounded-xl p-6 space-y-4">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-form-input label="Kode Objek" name="code" :value="$targetObject->code" required />
            <x-form-input label="Nomor Katalog" name="catalog_number" :value="$targetObject->catalog_number" required />
            <x-form-input label="Nama Objek Langit" name="name" :value="$targetObject->name" required />
            <x-form-input label="Kategori" name="category" :value="$targetObject->category" required />
        </div>
        <div>
            <label for="description" class="block text-xs font-medium text-slate-300 mb-1.5">Deskripsi</label>
            <textarea name="description" id="description" rows="3"
                      class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3.5 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">{{ old('description', $targetObject->description) }}</textarea>
        </div>
        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('target-objects.index') }}" class="rounded-lg bg-slate-800 px-4 py-2 text-sm text-slate-300">Batal</a>
            <button type="submit" class="rounded-lg bg-indigo-600 hover:bg-indigo-500 px-5 py-2 text-sm font-semibold text-white">Perbarui</button>
        </div>
    </form>
</div>
@endsection