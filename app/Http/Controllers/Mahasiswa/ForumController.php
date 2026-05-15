<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\ForumReply;
use App\Models\ForumReplyLike;
use App\Models\ForumThread;
use App\Models\LMSClass;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index()
    {
        $classes = auth()->user()->enrolledClasses()
            ->with(['forumThreads' => fn($q) => $q->withCount('replies')->latest()->take(5)])
            ->get();

        $recentThreads = ForumThread::whereIn('class_id', $classes->pluck('id'))
            ->with('user', 'class')
            ->withCount('replies')
            ->latest()
            ->take(10)
            ->get();

        return view('mahasiswa.forum.index', compact('classes', 'recentThreads'));
    }

    public function class(LMSClass $class)
    {
        $user = auth()->user();
        if (!$user->enrolledClasses()->where('class_id', $class->id)->exists()) abort(403);

        $class->load(['dosen', 'forumThreads' => function ($q) {
            $q->with('user')->withCount('replies')->latest();
        }]);

        return view('mahasiswa.forum.class', compact('class'));
    }

    public function show(ForumThread $thread)
    {
        $user = auth()->user();
        if (!$user->enrolledClasses()->where('class_id', $thread->class_id)->exists()) abort(403);

        $thread->load([
            'user',
            'class',
            'replies' => fn($q) => $q->with('user', 'likes', 'replies.user')->oldest(),
        ]);

        return view('mahasiswa.forum.show', compact('thread'));
    }

    public function reply(Request $request, ForumThread $thread)
    {
        $user = auth()->user();
        if (!$user->enrolledClasses()->where('class_id', $thread->class_id)->exists()) abort(403);

        $validated = $request->validate([
            'content' => 'required|string|min:1',
            'parent_id' => 'nullable|exists:forum_replies,id',
        ]);

        ForumReply::create([
            'forum_thread_id' => $thread->id,
            'user_id' => $user->id,
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        return redirect()->route('mahasiswa.forum.show', $thread)
            ->with('success', 'Balasan berhasil dikirim.');
    }

    public function like(ForumReply $reply)
    {
        $user = auth()->user();
        $thread = $reply->thread;
        if (!$user->enrolledClasses()->where('class_id', $thread->class_id)->exists()) abort(403);

        $existing = ForumReplyLike::where('forum_reply_id', $reply->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Like dihapus.');
        }

        ForumReplyLike::create([
            'forum_reply_id' => $reply->id,
            'user_id' => $user->id,
        ]);

        return back()->with('success', 'Balasan disukai.');
    }
}
