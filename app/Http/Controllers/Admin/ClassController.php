<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LMSClass;
use App\Models\User;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = LMSClass::with('dosen')->withCount('students')->latest()->paginate(20);
        return view('admin.classes.index', compact('classes'));
    }

    public function show(LMSClass $class)
    {
        $class->load(['dosen', 'students', 'materials', 'assignments']);
        return view('admin.classes.show', compact('class'));
    }

    public function destroy(LMSClass $class)
    {
        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Class deleted successfully.');
    }
}
