<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->hasRole('super_admin') || $user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->hasRole('dosen')) {
            return redirect()->route('dosen.dashboard');
        }
        if ($user->hasRole('mahasiswa')) {
            return redirect()->route('mahasiswa.dashboard');
        }

        return redirect()->route('login');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/dosen.php';
require __DIR__.'/mahasiswa.php';
