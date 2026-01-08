<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.gallery', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('image')->store('galleries', 'public');

        Gallery::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image_path'  => $path,
            'user_id'     => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Gambar berhasil diunggah!');
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'title_edit'       => 'required|string|max:255',
            'description_edit' => 'nullable|string',
            'image_edit'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update title dan description
        $gallery->title = $request->title_edit;
        $gallery->description = $request->description_edit;

        // Update image jika ada file baru
        if ($request->hasFile('image_edit')) {
            // Hapus file lama
            if ($gallery->image_path) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            // Simpan file baru
            $path = $request->file('image_edit')->store('galleries', 'public');
            $gallery->image_path = $path;
        }

        $gallery->save();

        return redirect()->back()->with('success', 'Gambar berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();

        return redirect()->back()->with('success', 'Gambar berhasil dihapus!');
    }
}
