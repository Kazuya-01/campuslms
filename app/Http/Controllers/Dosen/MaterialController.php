<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\LMSClass;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(LMSClass $class)
    {
        if ($class->dosen_id !== auth()->id()) abort(403);
        $materials = $class->materials()->ordered()->get();
        return view('dosen.materials.index', compact('class', 'materials'));
    }

    public function create(LMSClass $class)
    {
        if ($class->dosen_id !== auth()->id()) abort(403);
        return view('dosen.materials.create', compact('class'));
    }

    public function store(Request $request, LMSClass $class)
    {
        if ($class->dosen_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:file,video,link',
            'meeting_number' => 'nullable|integer|min:1',
            'order' => 'nullable|integer|min:0',
            'file_path' => 'nullable|file|max:51200',
            'video_url' => 'nullable|url',
            'link_url' => 'nullable|url',
        ]);

        $material = Material::create([
            'class_id' => $class->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
            'meeting_number' => $validated['meeting_number'] ?? null,
            'order' => $validated['order'] ?? 0,
        ]);

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $material->update([
                'file_path' => $file->store('materials', 'public'),
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
            ]);
        }

        if ($validated['type'] === 'video') {
            $material->update(['video_url' => $validated['video_url']]);
        }

        if ($validated['type'] === 'link') {
            $material->update(['link_url' => $validated['link_url']]);
        }

        return redirect()->route('dosen.classes.show', $class->slug)->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit(Material $material)
    {
        $class = $material->class;
        if ($class->dosen_id !== auth()->id()) abort(403);
        return view('dosen.materials.edit', compact('class', 'material'));
    }

    public function update(Request $request, Material $material)
    {
        $class = $material->class;
        if ($class->dosen_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:file,video,link',
            'meeting_number' => 'nullable|integer|min:1',
            'order' => 'nullable|integer|min:0',
            'video_url' => 'nullable|url',
            'link_url' => 'nullable|url',
        ]);

        $material->update($validated);

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $material->update([
                'file_path' => $file->store('materials', 'public'),
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
            ]);
        }

        return redirect()->route('dosen.classes.show', $class->slug)->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Material $material)
    {
        $class = $material->class;
        if ($class->dosen_id !== auth()->id()) abort(403);
        $material->delete();
        return redirect()->route('dosen.classes.show', $class->slug)->with('success', 'Materi berhasil dihapus.');
    }
}
