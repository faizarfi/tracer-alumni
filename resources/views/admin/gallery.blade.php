@extends('layouts.admin')

@section('title', 'Manajemen Galeri')

@section('content')
<style>
    /* Premium Gallery Card Styling */
    .glass-gallery-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 2rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .glass-gallery-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.1);
        border-color: #10b981;
    }

    /* Memperbaiki Overlay & Tombol Aksi */
    .image-container {
        position: relative;
        height: 14rem;
        overflow: hidden;
        background: #f1f5f9;
    }

    .action-overlay {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.6); /* Slate overlay lebih gelap agar tombol kontras */
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 40;
    }

    .glass-gallery-card:hover .action-overlay {
        opacity: 1;
    }

    .btn-action {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
    }

    /* Input & Label (Kontras Tinggi & Jarak) */
    .input-premium {
        @apply w-full bg-slate-50 border border-slate-300 rounded-2xl px-5 py-4 outline-none focus:border-green-600 focus:ring-4 focus:ring-green-500/10 transition-all text-sm font-bold text-slate-800 shadow-inner;
    }

    .label-premium {
        @apply text-[11px] font-black uppercase tracking-[0.2em] text-slate-500 mb-3 block ml-1;
    }

    /* Form Upload Wrapper dengan Jarak */
    .file-upload-wrapper {
        position: relative;
        width: 100%;
        height: 160px;
        border: 2px dashed #cbd5e1;
        border-radius: 1.5rem;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        transition: all 0.3s;
        margin-top: 0.5rem;
    }

    .file-upload-wrapper:hover {
        border-color: #10b981;
        background: #f0fdf4;
    }

    .file-upload-wrapper input[type="file"] {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 50;
    }

    /* Modal Divider & Header */
    .modal-header-divider {
        @apply border-b border-slate-100 px-8 py-6 flex items-center justify-between bg-slate-50/80 backdrop-blur-md;
    }
</style>

<div class="space-y-10 font-['Plus_Jakarta_Sans'] pb-12">

    {{-- HEADER SECTION --}}
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-gradient-to-tr from-purple-600 to-indigo-600 text-white rounded-[1.5rem] flex items-center justify-center shadow-xl shadow-purple-200">
                <i data-lucide="image" class="w-8 h-8"></i>
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Manajemen <span class="text-purple-600">Galeri</span></h1>
                <p class="text-slate-500 mt-1 font-bold uppercase text-[11px] tracking-[0.2em] flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    {{ $galleries->count() }} Media Terkatalog
                </p>
            </div>
        </div>

        <button onclick="openModal('add-photo-modal')" class="flex items-center gap-3 px-8 py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-black transition-all active:scale-95">
            <i data-lucide="plus-circle" class="w-5 h-5 text-emerald-400"></i> Unggah Foto Baru
        </button>
    </header>

    {{-- ALERTS --}}
    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-5 rounded-3xl animate-fade-in flex items-center gap-4 shadow-sm">
            <div class="w-10 h-10 bg-emerald-500 text-white rounded-xl flex items-center justify-center shadow-lg">
                <i data-lucide="check" class="w-6 h-6"></i>
            </div>
            <span class="text-sm font-black uppercase tracking-tight">{{ session('success') }}</span>
        </div>
    @endif

    {{-- GRID FOTO DENGAN JARAK --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($galleries as $gallery)
        <div class="glass-gallery-card group">
            <div class="image-container">
                <img src="{{ Storage::url($gallery->image_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                <div class="action-overlay">
                    <button type="button"
                            onclick="openEditModal({{ $gallery->id }}, '{{ addslashes($gallery->title) }}', '{{ addslashes($gallery->description) }}')"
                            class="btn-action bg-amber-500 hover:bg-amber-600 hover:scale-110 shadow-lg shadow-amber-900/20">
                        <i data-lucide="edit-3" class="w-6 h-6"></i>
                    </button>

                    <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Hapus data ini secara permanen?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-action bg-rose-600 hover:bg-rose-700 hover:scale-110 shadow-lg shadow-rose-900/20">
                            <i data-lucide="trash-2" class="w-6 h-6"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="p-8">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-10 h-1 bg-purple-500 rounded-full"></span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $gallery->created_at->translatedFormat('d M Y') }}</span>
                </div>
                <h3 class="font-black text-slate-800 text-base uppercase truncate mb-2 tracking-tight">{{ $gallery->title }}</h3>
                <p class="text-xs text-slate-500 font-medium line-clamp-2 leading-relaxed">
                    {{ $gallery->description ?? 'Tidak ada deskripsi tambahan untuk media ini.' }}
                </p>
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-200 shadow-inner">
            <i data-lucide="image-off" class="w-20 h-20 text-slate-200 mx-auto mb-6"></i>
            <p class="text-slate-400 font-black uppercase text-sm tracking-widest">Belum ada koleksi foto dalam database</p>
        </div>
        @endforelse
    </section>
</div>

{{-- MODAL UPLOAD DENGAN SKAT DAN JARAK --}}
<div id="add-photo-modal" class="hidden fixed inset-0 z-[100] bg-slate-900/80 backdrop-blur-md flex items-center justify-center p-4">
    <div class="bg-white rounded-[3rem] shadow-2xl w-full max-w-lg overflow-hidden animate-fade-in-up">
        <div class="modal-header-divider">
            <h3 class="font-black text-slate-800 uppercase text-sm tracking-widest flex items-center gap-3">
                <i data-lucide="upload-cloud" class="text-green-600"></i> Media Uploader
            </h3>
            <button onclick="closeModal('add-photo-modal')" class="w-10 h-10 flex items-center justify-center rounded-2xl hover:bg-rose-50 text-slate-400 hover:text-rose-500 transition-all"><i data-lucide="x" class="w-6 h-6"></i></button>
        </div>
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
            @csrf
            <div>
                <label class="label-premium">Judul Media</label>
                <input type="text" name="title" required class="input-premium" placeholder="Nama acara atau kategori kegiatan">
            </div>
            <div>
                <label class="label-premium">Deskripsi Singkat</label>
                <textarea name="description" rows="3" class="input-premium" placeholder="Ceritakan sedikit tentang foto ini..."></textarea>
            </div>
            <div>
                <label class="label-premium">Ambil File Gambar</label>
                <div class="file-upload-wrapper">
                    <input type="file" name="image" required onchange="updateFileName(this, 'add_fn')">
                    <div class="text-center p-4">
                        <i data-lucide="image-plus" class="w-10 h-10 text-slate-300 mx-auto mb-3"></i>
                        <p id="add_fn" class="text-xs font-black text-slate-400 uppercase tracking-tighter">Klik atau seret foto ke sini</p>
                    </div>
                </div>
            </div>
            <button type="submit" class="w-full py-5 bg-green-700 text-white rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-green-900/20 hover:bg-green-800 active:scale-95 transition-all flex items-center justify-center gap-3">
                <i data-lucide="send" class="w-4 h-4"></i> Submit Media
            </button>
        </form>
    </div>
</div>

{{-- MODAL EDIT DENGAN SKAT DAN JARAK --}}
<div id="edit-photo-modal" class="hidden fixed inset-0 z-[100] bg-slate-900/80 backdrop-blur-md flex items-center justify-center p-4">
    <div class="bg-white rounded-[3rem] shadow-2xl w-full max-w-lg overflow-hidden border-t-[8px] border-amber-500 animate-fade-in-up">
        <div class="modal-header-divider">
            <h3 class="font-black text-slate-800 uppercase text-sm tracking-widest flex items-center gap-3">
                <i data-lucide="edit-3" class="text-amber-600"></i> Update Content
            </h3>
            <button onclick="closeModal('edit-photo-modal')" class="w-10 h-10 flex items-center justify-center rounded-2xl hover:bg-rose-50 text-slate-400 hover:text-rose-500 transition-all"><i data-lucide="x" class="w-6 h-6"></i></button>
        </div>
        <form id="edit-gallery-form" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
            @csrf @method('PUT')
            <div>
                <label class="label-premium">Judul Media</label>
                <input type="text" name="title_edit" id="title_edit" required class="input-premium">
            </div>
            <div>
                <label class="label-premium">Ubah Deskripsi</label>
                <textarea name="description_edit" id="description_edit" rows="3" class="input-premium"></textarea>
            </div>
            <div>
                <label class="label-premium">Update File (Opsional)</label>
                <div class="file-upload-wrapper border-amber-200">
                    <input type="file" name="image_edit" onchange="updateFileName(this, 'edit_fn')">
                    <div class="text-center p-4">
                        <i data-lucide="refresh-cw" class="w-10 h-10 text-amber-300 mx-auto mb-3"></i>
                        <p id="edit_fn" class="text-xs font-black text-slate-400 uppercase italic tracking-tighter">Biarkan kosong jika tidak ingin ganti foto</p>
                    </div>
                </div>
            </div>
            <button type="submit" class="w-full py-5 bg-amber-600 text-white rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-amber-900/20 hover:bg-amber-700 active:scale-95 transition-all flex items-center justify-center gap-3">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openModal(id) {
        const el = document.getElementById(id);
        el.classList.remove('hidden');
        el.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        el.classList.add('hidden');
        el.classList.remove('flex');
        document.body.style.overflow = '';
    }

    function updateFileName(input, displayId) {
        const display = document.getElementById(displayId);
        if (input.files && input.files[0]) {
            display.textContent = "📂 TERPILIH: " + input.files[0].name;
            display.style.color = "#059669";
        }
    }

    function openEditModal(id, title, description) {
        const form = document.getElementById('edit-gallery-form');
        const urlTemplate = '{{ route("admin.gallery.update", ":id") }}';
        form.action = urlTemplate.replace(':id', id);

        document.getElementById('title_edit').value = title;
        document.getElementById('description_edit').value = description;

        openModal('edit-photo-modal');
    }

    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
@endpush
