<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\LMSClass;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('user', 'class')->latest()->paginate(20);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $classes = LMSClass::all();
        return view('admin.announcements.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'class_id' => 'nullable|exists:classes,id',
            'is_pinned' => 'boolean',
            'is_global' => 'boolean',
            'attachment' => 'nullable|file|max:10240',
        ]);

        $announcement = Announcement::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
            'class_id' => $validated['class_id'] ?? null,
            'is_pinned' => $validated['is_pinned'] ?? false,
            'is_global' => $validated['is_global'] ?? false,
        ]);

        if ($request->hasFile('attachment')) {
            $announcement->update(['attachment' => $request->file('attachment')->store('announcements', 'public')]);
        }

        if ($announcement->is_global) {
            NotificationService::sendToRole('mahasiswa', 'announcement', $announcement->title, strip_tags(Str::limit($announcement->content, 100)));
        } elseif ($announcement->class_id) {
            NotificationService::sendToClass($announcement->class_id, 'announcement', $announcement->title, strip_tags(Str::limit($announcement->content, 100)));
        }

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement published.');
    }

    public function edit(Announcement $announcement)
    {
        $classes = LMSClass::all();
        return view('admin.announcements.edit', compact('announcement', 'classes'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'class_id' => 'nullable|exists:classes,id',
            'is_pinned' => 'boolean',
            'is_global' => 'boolean',
        ]);

        $announcement->update($validated);

        if ($request->hasFile('attachment')) {
            $announcement->update(['attachment' => $request->file('attachment')->store('announcements', 'public')]);
        }

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted.');
    }
}
