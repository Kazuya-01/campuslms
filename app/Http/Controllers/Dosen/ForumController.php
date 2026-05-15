<?php

namespace App\Http\Controllers\Dosen;

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
        $classes = auth()->user()->dosenClasses()
            ->with(['forumThreads' => fn($q) => $q->withCount('replies')->latest()->take(5)])
            ->get();

        $recentThreads = ForumThread::whereIn('class_id', $classes->pluck('id'))
            ->with('user', 'class')
            ->withCount('replies')
            ->latest()
            ->take(10)
            ->get();

        return view('dosen.forum.index', compact('classes', 'recentThreads'));
    }

    public function class(LMSClass $class)
    {
        $user = auth()->user();
        if ($class->dosen_id !== $user->id) abort(403);

        $class->load(['forumThreads' => function ($q) {
            $q->with('user')->withCount('replies')->latest();
        }]);

        return view('dosen.forum.class', compact('class'));
    }

    public function create(LMSClass $class)
    {
        if ($class->dosen_id !== auth()->id()) abort(403);
        return view('dosen.forum.create', compact('class'));
    }

    public function store(Request $request, LMSClass $class)
    {
        if ($class->dosen_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_pinned' => 'nullable|boolean',
        ]);

        ForumThread::create([
            'class_id' => $class->id,
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_pinned' => $validated['is_pinned'] ?? false,
        ]);

        return redirect()->route('dosen.forum.class', $class)
            ->with('success', 'Thread forum berhasil dibuat.');
    }

    public function show(ForumThread $thread)
    {
        $user = auth()->user();
        $class = $thread->class;
        if ($class->dosen_id !== $user->id) {
            if (!$user->enrolledClasses()->where('class_id', $thread->class_id)->exists()) abort(403);
        }

        $thread->load([
            'user',
            'class',
            'replies' => fn($q) => $q->with('user', 'likes', 'replies.user')->oldest(),
        ]);

        return view('dosen.forum.show', compact('thread'));
    }

    public function reply(Request $request, ForumThread $thread)
    {
        $user = auth()->user();
        $class = $thread->class;
        if ($class->dosen_id !== $user->id) {
            if (!$user->enrolledClasses()->where('class_id', $thread->class_id)->exists()) abort(403);
        }

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

        return redirect()->route('dosen.forum.show', $thread)
            ->with('success', 'Balasan berhasil dikirim.');
    }

    public function like(ForumReply $reply)
    {
        $user = auth()->user();
        $thread = $reply->thread;
        $class = $thread->class;
        if ($class->dosen_id !== $user->id) {
            if (!$user->enrolledClasses()->where('class_id', $thread->class_id)->exists()) abort(403);
        }

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

    public function destroy(ForumThread $thread)
    {
        if ($thread->class->dosen_id !== auth()->id()) abort(403);
        $class = $thread->class;
        $thread->delete();
        return redirect()->route('dosen.forum.class', $class)
            ->with('success', 'Thread berhasil dihapus.');
    }
}
