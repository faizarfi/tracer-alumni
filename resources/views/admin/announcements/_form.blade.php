@php
    $pubVal = old('published_at') ?? optional(optional($announcement ?? null)->published_at)->format('Y-m-d\\TH:i') ?? '';
@endphp

<div class="space-y-6">
    <div class="space-y-4 p-4 md:p-6 border border-emerald-100 rounded-2xl bg-emerald-50/40">
        <h3 class="text-lg font-semibold text-emerald-800 mb-2 flex items-center gap-2">
            <i data-lucide="megaphone" class="w-4 h-4 text-emerald-600"></i>
            Detail Pengumuman
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                <input id="title" type="text" name="title" value="{{ old('title', optional($announcement ?? null)->title) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition text-sm" placeholder="Judul pengumuman" />
                @error('title') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-1">
                <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Publikasi (opsional)</label>
                <input id="published_at" type="datetime-local" name="published_at" value="{{ $pubVal }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition text-sm" />
                <p class="text-xs text-gray-500 mt-1">Kosongkan untuk langsung dipublikasikan.</p>
                @error('published_at') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-3">
                <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Isi <span class="text-red-500">*</span></label>
                <textarea id="body" name="body" rows="8" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition text-sm resize-y" placeholder="Tulis isi pengumuman">{{ old('body', optional($announcement ?? null)->body) }}</textarea>
                @error('body') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>
