<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizAttemptAnswer;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $classIds = auth()->user()->enrolledClasses()->pluck('class_id');
        $quizzes = Quiz::whereIn('class_id', $classIds)
            ->where('is_active', true)
            ->with('class', 'questions')
            ->latest()
            ->paginate(20);

        $attempted = QuizAttempt::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->pluck('quiz_id')
            ->toArray();

        return view('mahasiswa.quizzes.index', compact('quizzes', 'attempted'));
    }

    public function show(Quiz $quiz)
    {
        $user = auth()->user();
        if (!$user->enrolledClasses()->where('class_id', $quiz->class_id)->exists()) abort(403);
        if (!$quiz->is_active) abort(404);

        $existingAttempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->first();

        return view('mahasiswa.quizzes.show', compact('quiz', 'existingAttempt'));
    }

    public function start(Quiz $quiz)
    {
        $user = auth()->user();
        if (!$user->enrolledClasses()->where('class_id', $quiz->class_id)->exists()) abort(403);
        if (!$quiz->is_active) abort(404);

        $completed = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->first();

        if ($completed) {
            return redirect()->route('mahasiswa.quizzes.result', $quiz)->with('info', 'Kamu sudah mengerjakan quiz ini.');
        }

        $inProgress = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->first();

        if ($inProgress) {
            $quiz->load('questions');
            return view('mahasiswa.quizzes.attempt', ['quiz' => $quiz, 'attempt' => $inProgress]);
        }

        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => $user->id,
            'started_at' => now(),
            'status' => 'in_progress',
        ]);

        $quiz->load('questions');

        return view('mahasiswa.quizzes.attempt', compact('quiz', 'attempt'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $user = auth()->user();
        if (!$user->enrolledClasses()->where('class_id', $quiz->class_id)->exists()) abort(403);

        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->firstOrFail();

        $quiz->load('questions');

        $totalPoints = 0;
        $earnedPoints = 0;

        foreach ($quiz->questions as $question) {
            $answer = $request->input('question_' . $question->id);
            $isCorrect = null;
            $pointsEarned = 0;

            if ($question->type === 'multiple_choice') {
                $isCorrect = $answer === $question->correct_answer;
                $pointsEarned = $isCorrect ? $question->points : 0;
            } elseif ($question->type === 'essay') {
                $pointsEarned = 0;
                $isCorrect = null;
            }

            QuizAttemptAnswer::create([
                'quiz_attempt_id' => $attempt->id,
                'quiz_question_id' => $question->id,
                'answer' => $answer,
                'is_correct' => $isCorrect,
                'points_earned' => $pointsEarned,
            ]);

            $totalPoints += $question->points;
            $earnedPoints += $pointsEarned;
        }

        $attempt->update([
            'score' => $earnedPoints,
            'total_points' => $totalPoints,
            'finished_at' => now(),
            'status' => 'completed',
        ]);

        \App\Models\Grade::updateOrCreate(
            [
                'user_id' => $user->id,
                'class_id' => $quiz->class_id,
                'quiz_id' => $quiz->id,
                'type' => 'quiz',
            ],
            [
                'score' => $earnedPoints,
                'max_score' => $totalPoints,
            ]
        );

        return redirect()->route('mahasiswa.quizzes.result', $quiz)
            ->with('success', 'Quiz selesai!');
    }

    public function result(Quiz $quiz)
    {
        $user = auth()->user();
        if (!$user->enrolledClasses()->where('class_id', $quiz->class_id)->exists()) abort(403);

        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->with('answers.question')
            ->firstOrFail();

        return view('mahasiswa.quizzes.result', compact('quiz', 'attempt'));
    }
}
