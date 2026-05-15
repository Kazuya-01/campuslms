<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\LMSClass;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $classes = auth()->user()->enrolledClasses()->get();

        return view('mahasiswa.chat.index', compact('classes'));
    }

    public function class(LMSClass $class)
    {
        $user = auth()->user();
        if (! $user->enrolledClasses()->where('class_id', $class->id)->exists()) {
            abort(403);
        }

        $messages = ChatMessage::where('class_id', $class->id)
            ->with('user')->latest()->take(50)->get()->reverse();

        $classes = auth()->user()->enrolledClasses()->get();

        return view('mahasiswa.chat.index', compact('classes', 'class', 'messages'));
    }

    public function messages(LMSClass $class)
    {
        $user = auth()->user();
        if (! $user->enrolledClasses()->where('class_id', $class->id)->exists()) {
            abort(403);
        }

        $after = request('after');
        $query = ChatMessage::where('class_id', $class->id)->with('user')->latest()->take(50);

        if ($after) {
            $query->where('id', '>', $after);
        }

        return response()->json([
            'messages' => $query->get()->reverse()->values(),
        ]);
    }

    public function send(Request $request, LMSClass $class)
    {
        $user = auth()->user();
        if (! $user->enrolledClasses()->where('class_id', $class->id)->exists()) {
            abort(403);
        }

        $validated = $request->validate(['message' => 'required|string|max:1000']);

        $msg = ChatMessage::create([
            'class_id' => $class->id,
            'user_id' => $user->id,
            'message' => $validated['message'],
        ]);

        return response()->json(['message' => $msg->load('user')]);
    }

    public function update(Request $request, LMSClass $class, ChatMessage $message)
    {
        if ($message->user_id !== auth()->id()) {
            abort(403);
        }
        if ($message->class_id !== $class->id) {
            abort(404);
        }

        $validated = $request->validate(['message' => 'required|string|max:1000']);
        $message->update(['message' => $validated['message']]);

        return response()->json(['message' => $message->load('user')]);
    }

    public function destroy(LMSClass $class, ChatMessage $message)
    {
        if ($message->user_id !== auth()->id()) {
            abort(403);
        }
        if ($message->class_id !== $class->id) {
            abort(404);
        }

        $message->delete();

        return response()->json(['success' => true]);
    }
}
