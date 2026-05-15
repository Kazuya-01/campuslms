<?php

use App\Models\LMSClass;
use App\Models\Material;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::post('/login', function (Request $request) {
    $request->validate([
        'login' => 'required',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $login = $request->input('login');
    $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : (is_numeric($login) ? 'nim' : 'username');

    $user = User::where($field, $login)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'login' => ['The provided credentials are incorrect.'],
        ]);
    }

    return response()->json([
        'token' => $user->createToken($request->device_name)->plainTextToken,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->getRoleNames()->first(),
        ],
    ]);
})->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $r) => $r->user()->load('roles'));

    Route::get('/classes', fn () => LMSClass::with('dosen')->where('is_active', true)->get());
    Route::get('/classes/{class}', fn (LMSClass $class) => $class->load(['dosen', 'materials', 'assignments']));

    Route::get('/materials', fn () => Material::with('class')->where('is_active', true)->get());
    Route::get('/materials/{material}', fn (Material $material) => $material->load('class'));

    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    });
});
