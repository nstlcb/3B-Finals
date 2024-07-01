<?php

namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dex(Request $request)
    {
        $students = Student::query();

        // Filtering
        if ($request->has('course')) {
            $students->where('course', $request->course);
        }
        if ($request->has('year')) {
            $students->where('year', $request->year);
        }
        if ($request->has('section')) {
            $students->where('section', $request->section);
        }

        return response()->json($students->get());
    }

    public function stoe(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'birthdate' => 'required|date',
            'sex' => 'required|in:MALE,FEMALE',
            'address' => 'required|string',
            'year' => 'required|integer',
            'course' => 'required|string',
            'section' => 'required|string',
        ]);

        $student = Student::create($request->all());

        return response()->json($student, 201);
    }

    public function sho($id)
    {
        $student = Student::findOrFail($id);

        return response()->json($student);
    }

    public function up(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $student->update($request->all());

        return response()->json($student);
    }
}
