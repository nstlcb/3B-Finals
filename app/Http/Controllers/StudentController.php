<?php

namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dex(Request $request)
{
    $query = Student::query();

    if ($request->has('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('firstname', 'like', '%' . $request->search . '%')
              ->orWhere('lastname', 'like', '%' . $request->search . '%')
              ->orWhere('address', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->has('course')) {
        $query->where('course', $request->course);
    }

    if ($request->has('year')) {
        $query->where('year', $request->year);
    }

    if ($request->has('section')) {
        $query->where('section', $request->section);
    }

    if ($request->has('sort')) {
        $sort = ltrim($request->sort, '-');
        $direction = $request->sort[0] === '-' ? 'desc' : 'asc';
        $query->orderBy($sort, $direction);
    }

    if ($request->has('fields')) {
        $fields = explode(',', $request->fields);
        $query->select($fields);
    }

    $limit = $request->get('limit', 15);
    $offset = $request->get('offset', 0);

    $students = $query->limit($limit)->offset($offset)->get();

    $metadata = [
        'count' => $students->count(),
        'search' => $request->get('search', null),
        'limit' => $limit,
        'offset' => $offset,
        'fields' => $request->get('fields', []),
    ];

    return response()->json([
        'metadata' => $metadata,
        'students' => $students,
    ]);
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
