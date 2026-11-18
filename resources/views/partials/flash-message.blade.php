@if (session('success'))
    <div class="mb-6 rounded-xl bg-emerald-950/80 border border-emerald-500/50 px-4 py-3 text-sm text-emerald-200 flex items-center justify-between">
        <span>{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="mb-6 rounded-xl bg-rose-950/80 border border-rose-500/50 px-4 py-3 text-sm text-rose-200">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-xl bg-rose-950/80 border border-rose-500/50 px-4 py-3 text-sm text-rose-200">
        <p class="font-semibold mb-1">Periksa kembali isian formulir Anda:</p>
        <ul class="list-disc list-inside space-y-0.5 text-xs">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif