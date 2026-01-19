<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faculty;
use Illuminate\Support\Str;

class FacultyController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $faculties = Faculty::when($q, function($query, $q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->orderBy('name')
            ->paginate(20)
            ->appends($request->only('q'));

        return view('admin.faculties.index', compact('faculties'));
    }

    public function create()
    {
        return view('admin.faculties.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:faculties,name']);
        Faculty::create(['name' => $request->name, 'slug' => Str::slug($request->name)]);
        return redirect()->route('admin.faculties.index')->with('success', 'Fakultas berhasil ditambahkan.');
    }

    public function edit(Faculty $faculty)
    {
        return view('admin.faculties.edit', compact('faculty'));
    }

    public function update(Request $request, Faculty $faculty)
    {
        $request->validate(['name' => 'required|string|max:255|unique:faculties,name,' . $faculty->id]);
        $faculty->update(['name' => $request->name, 'slug' => Str::slug($request->name)]);
        return redirect()->route('admin.faculties.index')->with('success', 'Fakultas berhasil diperbarui.');
    }

    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
        return redirect()->route('admin.faculties.index')->with('success', 'Fakultas dihapus.');
    }
}
