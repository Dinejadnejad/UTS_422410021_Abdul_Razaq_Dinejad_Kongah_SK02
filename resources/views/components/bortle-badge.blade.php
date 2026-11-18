@props(['scale'])

@php
    $color = match(true) {
        $scale <= 3 => 'bg-emerald-500/15 text-emerald-300 border-emerald-500/40',
        $scale <= 6 => 'bg-amber-500/15 text-amber-300 border-amber-500/40',
        default     => 'bg-rose-500/15 text-rose-300 border-rose-500/40',
    };
    $label = match(true) {
        $scale <= 3 => 'Langit Gelap Ideal',
        $scale <= 6 => 'Transisi / Rural',
        default     => 'Polusi Cahaya Tinggi',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium border {$color}"]) }}>
    Bortle {{ $scale }} • {{ $label }}
</span>