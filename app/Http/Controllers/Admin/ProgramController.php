<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Faculty;
use Illuminate\Support\Str;

// Controller admin untuk mengelola program studi
class ProgramController extends Controller
{
    // Menangani: index(Request $request) - daftar program studi
    public function index(Request $request)
    {
        $q = $request->get('q');

        $programs = Program::with('faculty')
            ->when($q, function($query, $q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhereHas('faculty', function($q2) use ($q) {
                          $q2->where('name', 'like', "%{$q}%");
                      });
            })
            ->orderBy('name')
            ->paginate(20)
            ->appends($request->only('q'));

        return view('admin.programs.index', compact('programs'));
    }

    // Menangani: create() - tampilkan form tambah program studi
    public function create()
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.programs.create', compact('faculties'));
    }

    // Menangani: store(Request $request) - simpan program studi baru
    public function store(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'name' => 'required|string|max:255'
        ]);

        Program::create([
            'faculty_id' => $request->faculty_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.programs.index')->with('success', 'Program Studi berhasil ditambahkan.');
    }

    // Menangani: edit(Program $program) - tampilkan form edit program
    public function edit(Program $program)
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.programs.edit', compact('program', 'faculties'));
    }

    // Menangani: update(Request $request, Program $program) - perbarui program studi
    public function update(Request $request, Program $program)
    {
        $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'name' => 'required|string|max:255'
        ]);

        $program->update([
            'faculty_id' => $request->faculty_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.programs.index')->with('success', 'Program Studi diperbarui.');
    }

    // Menangani: destroy(Program $program) - hapus program studi
    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Program Studi dihapus.');
    }
}
