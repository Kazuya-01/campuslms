<?php

use App\Http\Controllers\Dosen\AssignmentController;
use App\Http\Controllers\Dosen\CertificateController as DosenCertificateController;
use App\Http\Controllers\Dosen\ClassController as DosenClassController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\ForumController as DosenForumController;
use App\Http\Controllers\Dosen\MaterialController;
use App\Http\Controllers\Dosen\QuizController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dashboard');

    Route::resource('classes', DosenClassController::class);
    Route::get('classes/{class}/students', [DosenClassController::class, 'students'])->name('classes.students');
    Route::delete('classes/{class}/students/{user}', [DosenClassController::class, 'removeStudent'])->name('classes.students.remove');

    Route::resource('classes.materials', MaterialController::class)->shallow();
    Route::get('assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::get('assignments/{assignment}', [AssignmentController::class, 'show'])->name('assignments.show');
    Route::get('assignments/{assignment}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
    Route::put('assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
    Route::delete('assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');
    Route::post('assignments/{submission}/grade', [AssignmentController::class, 'grade'])->name('assignments.grade');

    Route::get('quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
    Route::post('quizzes', [QuizController::class, 'store'])->name('quizzes.store');
    Route::get('quizzes/{quiz}/questions', [QuizController::class, 'questions'])->name('quizzes.questions');
    Route::post('quizzes/{quiz}/questions', [QuizController::class, 'storeQuestion'])->name('quizzes.questions.store');
    Route::put('quizzes/{quiz}/questions/{question}', [QuizController::class, 'updateQuestion'])->name('quizzes.questions.update');
    Route::delete('quizzes/{quiz}/questions/{question}', [QuizController::class, 'destroyQuestion'])->name('quizzes.questions.destroy');
    Route::get('quizzes/{quiz}/attempts', [QuizController::class, 'attempts'])->name('quizzes.attempts');
    Route::post('quizzes/{quiz}/toggle', [QuizController::class, 'toggle'])->name('quizzes.toggle');

    Route::get('certificates', [DosenCertificateController::class, 'index'])->name('certificates.index');
    Route::get('certificates/create', [DosenCertificateController::class, 'create'])->name('certificates.create');
    Route::post('certificates', [DosenCertificateController::class, 'store'])->name('certificates.store');
    Route::get('certificates/{certificate}/download', [DosenCertificateController::class, 'download'])->name('certificates.download');

    Route::get('calendar', [App\Http\Controllers\Dosen\CalendarController::class, 'index'])->name('calendar.index');

    Route::get('chat', [App\Http\Controllers\Dosen\ChatController::class, 'index'])->name('chat.index');
    Route::get('chat/{class}', [App\Http\Controllers\Dosen\ChatController::class, 'class'])->name('chat.class');
    Route::get('chat/{class}/messages', [App\Http\Controllers\Dosen\ChatController::class, 'messages'])->name('chat.messages');
    Route::post('chat/{class}/send', [App\Http\Controllers\Dosen\ChatController::class, 'send'])->name('chat.send');

    Route::get('forum', [DosenForumController::class, 'index'])->name('forum.index');
    Route::get('forum/class/{class}', [DosenForumController::class, 'class'])->name('forum.class');
    Route::get('forum/class/{class}/create', [DosenForumController::class, 'create'])->name('forum.create');
    Route::post('forum/class/{class}', [DosenForumController::class, 'store'])->name('forum.store');
    Route::get('forum/thread/{thread}', [DosenForumController::class, 'show'])->name('forum.show');
    Route::post('forum/thread/{thread}/reply', [DosenForumController::class, 'reply'])->name('forum.reply');
    Route::post('forum/reply/{reply}/like', [DosenForumController::class, 'like'])->name('forum.like');
    Route::delete('forum/thread/{thread}', [DosenForumController::class, 'destroy'])->name('forum.destroy');
});
