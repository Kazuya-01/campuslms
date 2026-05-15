<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\LMSClass;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $classIds = LMSClass::where('dosen_id', auth()->id())->pluck('id');
        $quizzes = Quiz::whereIn('class_id', $classIds)->with('class', 'questions')->latest()->paginate(20);
        return view('dosen.quizzes.index', compact('quizzes'));
    }

    public function create(Request $request)
    {
        $classes = LMSClass::where('dosen_id', auth()->id())->get();
        $selectedClass = $request->class_id ? LMSClass::find($request->class_id) : null;
        return view('dosen.quizzes.create', compact('classes', 'selectedClass'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'nullable|integer|min:1',
            'max_score' => 'required|numeric|min:0',
            'random_questions' => 'boolean',
            'random_answers' => 'boolean',
            'allow_review' => 'boolean',
        ]);

        $class = LMSClass::findOrFail($validated['class_id']);
        if ($class->dosen_id !== auth()->id()) abort(403);

        $quiz = Quiz::create([
            'class_id' => $validated['class_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'time_limit' => $validated['time_limit'] ?? null,
            'max_score' => $validated['max_score'],
            'random_questions' => $validated['random_questions'] ?? false,
            'random_answers' => $validated['random_answers'] ?? false,
            'allow_review' => $validated['allow_review'] ?? false,
            'is_active' => true,
        ]);

        NotificationService::sendToClass($quiz->class_id, 'quiz', 'New Quiz: ' . $quiz->title);

        return redirect()->route('dosen.quizzes.questions', $quiz->id)->with('success', 'Quiz created. Add questions now.');
    }

    public function questions(Quiz $quiz)
    {
        if ($quiz->class->dosen_id !== auth()->id()) abort(403);
        $quiz->load('questions');
        return view('dosen.quizzes.questions', compact('quiz'));
    }

    public function storeQuestion(Request $request, Quiz $quiz)
    {
        if ($quiz->class->dosen_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'type' => 'required|in:multiple_choice,essay',
            'question' => 'required|string',
            'options' => 'nullable|array',
            'options.*' => 'required|string',
            'correct_answer' => 'nullable|string',
            'points' => 'required|integer|min:0',
        ]);

        $quiz->questions()->create([
            'type' => $validated['type'],
            'question' => $validated['question'],
            'options' => $validated['type'] === 'multiple_choice' ? $validated['options'] : null,
            'correct_answer' => $validated['correct_answer'],
            'points' => $validated['points'],
            'order' => $quiz->questions()->count() + 1,
        ]);

        return back()->with('success', 'Question added.');
    }

    public function updateQuestion(Request $request, Quiz $quiz, QuizQuestion $question)
    {
        if ($quiz->class->dosen_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'type' => 'required|in:multiple_choice,essay',
            'question' => 'required|string',
            'options' => 'nullable|array',
            'correct_answer' => 'nullable|string',
            'points' => 'required|integer|min:0',
        ]);

        $question->update([
            'type' => $validated['type'],
            'question' => $validated['question'],
            'options' => $validated['type'] === 'multiple_choice' ? $validated['options'] : null,
            'correct_answer' => $validated['correct_answer'],
            'points' => $validated['points'],
        ]);

        return back()->with('success', 'Question updated.');
    }

    public function destroyQuestion(Quiz $quiz, QuizQuestion $question)
    {
        if ($quiz->class->dosen_id !== auth()->id()) abort(403);
        $question->delete();
        return back()->with('success', 'Question deleted.');
    }

    public function attempts(Quiz $quiz)
    {
        if ($quiz->class->dosen_id !== auth()->id()) abort(403);
        $attempts = QuizAttempt::where('quiz_id', $quiz->id)->with('user')->latest()->paginate(20);
        return view('dosen.quizzes.attempts', compact('quiz', 'attempts'));
    }

    public function toggle(Quiz $quiz)
    {
        if ($quiz->class->dosen_id !== auth()->id()) abort(403);
        $quiz->update(['is_active' => !$quiz->is_active]);
        return back()->with('success', 'Quiz status updated.');
    }
}
