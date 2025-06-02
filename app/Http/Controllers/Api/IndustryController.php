<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Industry;

class IndustryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $industry = Industry::get();
        return response()->json($industry, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $industry = new Industri(); 
        $industry->name = $request->name;
        $industry->picture = $request->picture;
        $industry->industry_sector = $request->industry_sector;
        $industry->address = $request->address;
        $industry->contact = $request->contact;
        $industry->email = $request->email;
        $industry->website = $request->website;
        $industry->save(); // menyimpan ke database
        return response()->json($industry, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $industry = Industry::find($id);
        return response()->json($industry, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $industry = Industry::find($id);
        if (!$industry) {
            return response()->json(['message' => 'Industry not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'picture' => 'sometimes|string',
            'industry_sector' => 'sometimes|required|string',
            'address' => 'sometimes|required|string',
            'contact' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:industries,email,' . $industry->id,
            'website' => 'sometimes|required|url',
        ]);

        $industry->name = $request->name ?? $industry->name;
        $industry->picture = $request->picture ?? $industry->picture;
        $industry->industry_sector = $request->industry_sector ?? $industry->industry_sector;
        $industry->address = $request->address ?? $industry->address;
        $industry->contact = $request->contact ?? $industry->contact;
        $industry->email = $request->email ?? $industry->email;
        $industry->website = $request->website ?? $industry->website;
        $industry->save();

        return response()->json($industry, 200); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Industry::destroy($id); // menghapus baris dengan ID yang dimaksud
        return response()->json(["message"=>"Deleted"], 200);
    }
}