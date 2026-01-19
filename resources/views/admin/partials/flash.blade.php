@if(session('success'))
    <div class="p-4 rounded-lg bg-emerald-50 border border-emerald-100 text-emerald-700">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="p-4 rounded-lg bg-rose-50 border border-rose-100 text-rose-700">{{ session('error') }}</div>
@endif
