<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use Illuminate\Http\Request;

class ShoeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shoes = Shoe::all();

        return response()->json($shoes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'size' => 'required|integer',
                'color' => 'required|string',
                'price' => 'required|numeric',
            ]);
            $shoe = Shoe::create($validated);

            return response()->json($shoe, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Shoe $shoe)
    {
        return response()->json($shoe, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shoe $shoe)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'size' => 'required|integer',
                'color' => 'required|string',
                'price' => 'required|numeric',
            ]);

            $shoe->update($validated);

            return response()->json($shoe, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shoe $shoe)
    {
        try {
            $shoe->delete();

            return response()->json(['message' => 'shoe deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
