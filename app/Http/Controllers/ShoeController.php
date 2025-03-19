<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use Illuminate\Http\Request;

class ShoeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/shoes",
     *     summary="get list of shoes",
     *     tags={"Shoes"},
     *     @OA\Response(
     *         response=200,
     *         description="list of shoes",
     *     )
     * )
     */
    public function index()
    {
        $shoes = Shoe::all();

        return response()->json($shoes);
    }

    /**
     * @OA\Post(
     *     path="/api/shoes",
     *     summary="create new shoe",
     *     tags={"Shoes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","size","color","price"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="size", type="integer"),
     *             @OA\Property(property="color", type="string"),
     *             @OA\Property(property="price", type="number")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Shoe created",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/shoes/{id}",
     *     summary="show specified shoe",
     *     tags={"Shoes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Shoe ID",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="shoe details",
     *     )
     * )
     */
    public function show(Shoe $shoe)
    {
        return response()->json($shoe, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/shoes/{id}",
     *     summary="Update shoe details",
     *     tags={"Shoes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Shoe ID",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","size","color","price"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="size", type="integer"),
     *             @OA\Property(property="color", type="string"),
     *             @OA\Property(property="price", type="number")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Shoe updated successfully",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/shoes/{id}",
     *     summary="Delete shoe",
     *     tags={"Shoes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Shoe ID",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Shoe deleted",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *     )
     * )
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
