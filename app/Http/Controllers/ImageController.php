<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageCollection;
use App\Models\Image;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $images = new ImageCollection(Image::all());
            return response()->json([
                $images,
            ]);
        } catch (Exception $e) {
            return response()->json(
                ['error' => 'An error occurred while trying to retrieve images.'],
                500
            );
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $image = Image::create([
                "title" => $request->title,
                'label'->$request->label,
                "url" => Storage::putFile('images', $request->file('url')), /*  $request->file('url')->store("images/main") */
            ]);
            return response()->json([$image]);
        } catch (Exception $e) {
            return response()->json(["error" => "Error uploading file"], 422);
        }

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image)
    {
        // $image = findOrFail($id);
        try {
            $image->update([
                "title" => $request->input("title"),
                'label'->$request->input("label"),
                "url" => $request->input("url"),
            ]);
        } catch (Exception $e) {
            return response()->json(["error" => "Failed to update image."], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }
}
