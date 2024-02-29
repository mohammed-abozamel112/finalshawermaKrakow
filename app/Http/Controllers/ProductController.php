<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = new ProductCollection(Product::all());
            return response()->json([
                'success' => true,
                $products,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $product = Product::create(
                [
                    'name' => $request->name,
                    'description' => $request->description,
                    'category' => $request->category,
                    'quantity' => $request->quantity,
                    'availability' => filter_var($request->availability, FILTER_VALIDATE_BOOLEAN),
                    'top_product' => filter_var($request->top_product, FILTER_VALIDATE_BOOLEAN),
                    'weight' => $request->weight,
                    'price_before_discount' => $request->price_before_discount,
                    'image' => Storage::putFile('images', $request->file('image')),
                ]
            );
            return response()->json([
                "success" => true,
                $product,
            ]);

        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        try {
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
                'quantity' => $request->quantity,
                'availability' => filter_var($request->availability, FILTER_VALIDATE_BOOLEAN),
                'top_product' => filter_var($request->top_product, FILTER_VALIDATE_BOOLEAN),
                'weight' => $request->weight,
                'price_before_discount' => $request->price_before_discount,
                'image' => Storage::putFile('images', $request->file('image')),
            ]);
            return response()->json([
                'success' => true,
                $product
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
