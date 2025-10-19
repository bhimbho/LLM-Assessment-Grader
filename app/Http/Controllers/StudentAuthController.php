<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    public function index()
    {
        return view('student.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $student = Student::where('student_id', $request->student_id)->first();

        if ($student && Hash::check($request->password, $student->password)) {
            Auth::guard('student')->login($student);
            return redirect()->route('student.dashboard');
        }

        return redirect()->back()->withErrors('Invalid student ID or password');
    }

    public function logout()
    {
        Auth::guard('student')->logout();
        return redirect()->route('student.login');
    }
}