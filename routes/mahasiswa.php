<?php

use App\Http\Controllers\Mahasiswa\AssignmentController;
use App\Http\Controllers\Mahasiswa\CertificateController;
use App\Http\Controllers\Mahasiswa\ClassController as MahasiswaClassController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\ForumController as MahasiswaForumController;
use App\Http\Controllers\Mahasiswa\GradeController;
use App\Http\Controllers\Mahasiswa\QuizController as MahasiswaQuizController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');

    Route::get('classes', [MahasiswaClassController::class, 'index'])->name('classes.index');
    Route::get('classes/{class}', [MahasiswaClassController::class, 'show'])->name('classes.show');
    Route::post('classes/join', [MahasiswaClassController::class, 'join'])->name('classes.join');
    Route::post('classes/{class}/materials/{material}/mark', [MahasiswaClassController::class, 'markMaterial'])->name('classes.materials.mark');
    Route::get('classes/{class}/materials/{material}', [MahasiswaClassController::class, 'viewMaterial'])->name('classes.materials.view');

    Route::get('assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('assignments/{assignment}', [AssignmentController::class, 'show'])->name('assignments.show');
    Route::post('assignments/{assignment}/submit', [AssignmentController::class, 'submit'])->name('assignments.submit');

    Route::get('grades', [GradeController::class, 'index'])->name('grades.index');
    Route::get('certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');

    Route::get('calendar', [App\Http\Controllers\Mahasiswa\CalendarController::class, 'index'])->name('calendar.index');

    Route::get('chat', [App\Http\Controllers\Mahasiswa\ChatController::class, 'index'])->name('chat.index');
    Route::get('chat/{class}', [App\Http\Controllers\Mahasiswa\ChatController::class, 'class'])->name('chat.class');
    Route::get('chat/{class}/messages', [App\Http\Controllers\Mahasiswa\ChatController::class, 'messages'])->name('chat.messages');
    Route::post('chat/{class}/send', [App\Http\Controllers\Mahasiswa\ChatController::class, 'send'])->name('chat.send');

    Route::get('quizzes', [MahasiswaQuizController::class, 'index'])->name('quizzes.index');
    Route::get('quizzes/{quiz}', [MahasiswaQuizController::class, 'show'])->name('quizzes.show');
    Route::match(['get', 'post'], 'quizzes/{quiz}/start', [MahasiswaQuizController::class, 'start'])->name('quizzes.start');
    Route::post('quizzes/{quiz}/submit', [MahasiswaQuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('quizzes/{quiz}/result', [MahasiswaQuizController::class, 'result'])->name('quizzes.result');

    Route::get('forum', [MahasiswaForumController::class, 'index'])->name('forum.index');
    Route::get('forum/class/{class}', [MahasiswaForumController::class, 'class'])->name('forum.class');
    Route::get('forum/thread/{thread}', [MahasiswaForumController::class, 'show'])->name('forum.show');
    Route::post('forum/thread/{thread}/reply', [MahasiswaForumController::class, 'reply'])->name('forum.reply');
    Route::post('forum/reply/{reply}/like', [MahasiswaForumController::class, 'like'])->name('forum.like');
});
