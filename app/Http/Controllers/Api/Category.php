<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryResponse;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category as ModelsCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Category extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CategoryResource::collection(ModelsCategory::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $validatedFilled = $request->validated();

        $category = auth()->user()->categories()->create($validatedFilled);

        // $category = ModelsCategory::create($validatedFilled);



        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(ModelsCategory $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, ModelsCategory $category)
    {
        try {
            $validatedData = $request->validated();
            $updated = $category->update($validatedData);
            if (!$updated) {
                throw new \Exception('Failed to update the category.');
            }
            return response()->json(['message' => 'Category updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelsCategory $category)
    {
        $category->delete();
        return response()->noContent();
    }
}
