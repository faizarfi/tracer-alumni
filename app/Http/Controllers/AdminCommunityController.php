<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;

// Controller untuk mengelola komunitas (Admin)
class AdminCommunityController extends Controller
{
    # Menangani: index()
    public function index()
    {
        $communities = Community::orderBy('sort_order')->get();
        return view('admin.community.index', compact('communities'));
    }

    # Menangani: create()
    public function create()
    {
        return view('admin.community.create');
    }

    # Menangani: store(Request $request)
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'url' => 'nullable|url|max:1000',
            'sort_order' => 'nullable|integer',
            'active' => 'nullable|boolean'
        ]);
        $data['active'] = $request->has('active');
        Community::create($data);
        return redirect()->route('admin.community.index')->with('success','Komunitas berhasil ditambahkan.');
    }

    # Menangani: edit(Community $community)
    public function edit(Community $community)
    {
        return view('admin.community.edit', compact('community'));
    }

    # Menangani: update(Request $request, Community $community)
    public function update(Request $request, Community $community)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'url' => 'nullable|url|max:1000',
            'sort_order' => 'nullable|integer',
            'active' => 'nullable|boolean'
        ]);
        $data['active'] = $request->has('active');
        $community->update($data);
        return redirect()->route('admin.community.index')->with('success','Komunitas diperbarui.');
    }

    # Menangani: destroy(Community $community)
    public function destroy(Community $community)
    {
        $community->delete();
        return redirect()->route('admin.community.index')->with('success','Komunitas dihapus.');
    }
}
