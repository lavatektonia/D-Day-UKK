<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = Student::get();
        return response()->json($student, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $student = new Student(); 
        $student->name = $request->name;
        $student->nis = $request->nis;
        $student->gender = $request->gender;
        $student->class_group = $request->class_group;
        $student->address = $request->address;
        $student->contact = $request->contact;
        $student->email = $request->email;
        $student->photo = $request->photo;
        $student->pkl_report_status = $request->pkl_report_status;
        $student->save(); // menyimpan ke database
        return response()->json($student, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id); 
        return response()->json($student, 200); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'nis' => 'sometimes|required|numeric|unique:students,nis,' . $student->id,
            'gender' => 'sometimes|required|in:Laki-laki,Perempuan',
            'class_group' => 'sometimes|required|in:SIJA A,SIJA B',
            'address' => 'sometimes|required|string',
            'contact' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:students,email,' . $student->id,
            'photo' => 'sometimes|nullable|image|max:2048',
            'pkl_report_status' => 'sometimes|required|boolean',
        ]);

        $student->name = $request->name ?? $student->name;
        $student->nis = $request->nis ?? $student->nis;
        $student->gender = $request->gender ?? $student->gender;
        $student->class_group = $request->class_group ?? $student->class_group;
        $student->address = $request->address ?? $student->address;
        $student->contact = $request->contact ?? $student->contact;
        $student->email = $request->email ?? $student->email;
        $student->photo = $request->photo ?? $student->photo;
        $student->pkl_report_status = $request->pkl_report_status ?? $student->pkl_report_status;
        $student->save();

        return response()->json($student, 200); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Student::destroy($id); // menghapus baris dengan ID yang dimaksud
        return response()->json(["message"=>"Deleted"], 200);
    }
}