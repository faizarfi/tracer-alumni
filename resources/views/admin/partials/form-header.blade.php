@php
    // params: $icon, $title, $subtitle, $backRoute
    $icon = $icon ?? 'box';
    $title = $title ?? 'Form';
    $subtitle = $subtitle ?? '';
    $backRoute = $backRoute ?? null;
@endphp

<header class="flex items-center justify-between mb-4">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 bg-emerald-500 text-white rounded-xl flex items-center justify-center shadow">
            <i data-lucide="{{ $icon }}" class="w-6 h-6"></i>
        </div>
        <div>
            <h1 class="text-2xl font-black text-slate-900">{{ $title }}</h1>
            @if($subtitle)
                <p class="text-sm text-slate-500">{{ $subtitle }}</p>
            @endif
        </div>
    </div>
    @if($backRoute)
        <div class="flex items-center gap-2">
            <a href="{{ $backRoute }}" class="px-3 py-2 text-sm text-slate-600 bg-white border border-slate-100 rounded-lg shadow-sm hover:bg-slate-50">Kembali</a>
        </div>
    @endif
</header>
