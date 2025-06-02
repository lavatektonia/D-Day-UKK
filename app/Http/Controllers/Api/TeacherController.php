<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher = Teacher::get();
        return response()->json($teacher, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $teacher = new Teacher(); 
        $teacher->name = $request->name;
        $teacher->nip = $request->nip;
        $teacher->gender = $request->gender;
        $teacher->address = $request->address;
        $teacher->contact_value = $request->contact_value;
        $teacher->contact_type = $request->contact_type;
        $teacher->email = $request->email;
        $teacher->save(); // menyimpan ke database
        return response()->json($teacher, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $teacher = teacher::find($id); 
        return response()->json($teacher, 200); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'nip' => 'sometimes|required|numeric|unique:teachers,nip,' . $teacher->id,
            'gender' => 'sometimes|required|in:Male,Female',
            'address' => 'sometimes|required|string',
            'contact_value' => 'sometimes|required|string',
            'contact_type' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:teachers,email,' . $teacher->id,
        ]);

        $request->name = $request->name ?? $teacher->name;
        $request->nip = $request->nip ?? $teacher->nip;
        $request->gender = $request->gender ?? $teacher->gender;
        $request->address = $request->address ?? $teacher->address;
        $request->contact_value = $request->contact_value ?? $teacher->contact_value;
        $request->contact_type = $request->contact_type ?? $teacher->contact_type;
        $request->email = $request->email ?? $teacher->email;
        $request->save();

        return response()->json($teacher, 200); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Teacher::destroy($id); // menghapus baris dengan ID yang dimaksud
        return response()->json(["message"=>"Deleted"], 200);
    }
}