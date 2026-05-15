<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\LMSClass;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $classes = auth()->user()->dosenClasses()->get();
        return view('dosen.chat.index', compact('classes'));
    }

    public function class(LMSClass $class)
    {
        if ($class->dosen_id !== auth()->id()) abort(403);

        $messages = ChatMessage::where('class_id', $class->id)
            ->with('user')->latest()->take(50)->get()->reverse();

        $classes = auth()->user()->dosenClasses()->get();
        return view('dosen.chat.index', compact('classes', 'class', 'messages'));
    }

    public function messages(LMSClass $class)
    {
        if ($class->dosen_id !== auth()->id()) abort(403);

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
        if ($class->dosen_id !== auth()->id()) abort(403);

        $validated = $request->validate(['message' => 'required|string|max:1000']);

        $msg = ChatMessage::create([
            'class_id' => $class->id,
            'user_id' => auth()->id(),
            'message' => $validated['message'],
        ]);

        if ($request->wantsJson()) {
            return response()->json(['message' => $msg->load('user')]);
        }

        return redirect()->route('dosen.chat.class', $class);
    }
}
