@extends('layouts.admin')

@section('title', 'Tambah Komunitas')

@section('content')
<div class="p-8">
    <h1 class="text-2xl font-black mb-6">Tambah Komunitas</h1>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.community.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Tipe (mis. Telegram, WhatsApp)</label>
            <input type="text" name="type" value="{{ old('type') }}" class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">URL</label>
            <input type="url" name="url" value="{{ old('url') }}" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="active" value="1" {{ old('active') ? 'checked' : '' }}>
                <span class="ml-2">Aktif</span>
            </label>
        </div>
        <div>
            <button class="px-4 py-2 bg-emerald-600 text-white rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection
