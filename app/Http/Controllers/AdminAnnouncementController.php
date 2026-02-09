<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

// Controller untuk mengelola pengumuman (Admin)
class AdminAnnouncementController extends Controller
{
    # Menangani: create()
    public function create()
    {
        return view('admin.announcements.create');
    }

    # Menangani: store(Request $request)
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'published_at' => 'nullable|date'
        ]);

        Announcement::create($data + ['published_at' => $data['published_at'] ?? now()]);

        return redirect()->route('admin.dashboard')->with('success', 'Pengumuman berhasil dibuat.');
    }

    # Menangani: edit(Announcement $announcement)
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    # Menangani: update(Request $request, Announcement $announcement)
    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'published_at' => 'nullable|date'
        ]);

        $announcement->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Pengumuman diperbarui.');
    }

    # Menangani: destroy(Announcement $announcement)
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Pengumuman dihapus.');
    }
}
