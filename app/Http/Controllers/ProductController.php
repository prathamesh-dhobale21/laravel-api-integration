<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (! $request->has('name') || is_null($request->input('name')) || trim($request->input('name')) === '') {
            return response()->json([
                'message' => 'Name is required and cannot be null or empty'
            ], 422);
        }

        if (! $request->has('detail') || is_null($request->input('detail')) || trim($request->input('detail')) === '') {
            return response()->json([
                'message' => 'Detail is required and cannot be null or empty'
            ], 422);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'required|string',
        ]);

        $product = Product::create($validatedData);

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
                'message' => 'Unauthorized or Product not found'
            ], 404);
        }
        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
                'message' => 'Unauthorized or Product not found'
            ], 404);
        }

        if (! $request->has('name') || is_null($request->input('name')) || trim($request->input('name')) === '') {
            return response()->json([
                'message' => 'Name is required and cannot be null or empty'
            ], 422);
        }

        if (! $request->has('detail') || is_null($request->input('detail')) || trim($request->input('detail')) === '') {
            return response()->json([
                'message' => 'Detail is required and cannot be null or empty'
            ], 422);
        }

        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $product->update($request->all());

        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
                'message' => 'Unauthorized or Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json(null, 204);
    }
}
