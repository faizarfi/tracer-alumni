@extends('layouts.admin')

@section('title', 'Kelola Komunitas')

@section('content')
<div class="p-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-black">Kelola Komunitas</h1>
        <a href="{{ route('admin.community.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg">Tambah Komunitas</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-emerald-50 text-emerald-700 rounded">{{ session('success') }}</div>
    @endif

    @if($communities->isEmpty())
        <div class="p-6 bg-white rounded border">Belum ada komunitas.</div>
    @else
    <table class="w-full text-left bg-white rounded overflow-hidden">
        <thead class="bg-slate-50 text-xs uppercase text-slate-500 font-black">
            <tr>
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Tipe</th>
                <th class="px-4 py-3">URL</th>
                <th class="px-4 py-3">Aktif</th>
                <th class="px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($communities as $c)
            <tr class="border-t">
                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                <td class="px-4 py-3 font-bold">{{ $c->name }}</td>
                <td class="px-4 py-3">{{ $c->type }}</td>
                <td class="px-4 py-3 break-all">{{ $c->url }}</td>
                <td class="px-4 py-3">{{ $c->active ? 'Ya' : 'Tidak' }}</td>
                <td class="px-4 py-3">
                    <a href="{{ route('admin.community.edit', $c->id) }}" class="text-amber-600 mr-2">Edit</a>
                    <form action="{{ route('admin.community.destroy', $c->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus komunitas?');">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
