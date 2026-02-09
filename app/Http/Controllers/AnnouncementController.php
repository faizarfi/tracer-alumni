<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

// Controller publik untuk menampilkan pengumuman
class AnnouncementController extends Controller
{
    # Menangani: index() - daftar pengumuman publik
    public function index()
    {
        $announcements = Announcement::latest('published_at')->take(10)->get();
        return view('announcements.index', compact('announcements'));
    }

    # Menangani: show(Announcement $announcement) - tampilkan pengumuman tertentu
    public function show(Announcement $announcement)
    {
        return view('announcements.show', compact('announcement'));
    }
}
