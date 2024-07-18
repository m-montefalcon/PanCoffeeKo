<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ProductCategory::getActiveProducts();
        return response()->json([
            'categories' => $categories,
            'meta' => [
                'last_page' => $categories->lastPage(), // Total number of pages
            ],
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductCategoryRequest $request)
    {
        $validatedData = $request->validated();
        try {
            ProductCategory::create($validatedData);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error storing product category' . $e->getMessage()
            ], 500);
        }
        //
        return response()->json([
            'message' => 'Product Category added successfully',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCategoryRequest $request)
    {
        $validatedData = $request->validated();
        $product = ProductCategory::find($validatedData['id']);
        if (!$product) {
            return response()->json([
                'error' => 'Product not found'
            ]);
        }
        try {
            $product->update($validatedData);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error updating product categories' . $e->getMessage()
            ]);
        }

        return response()->json([
            'message' => 'Product Category updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = ProductCategory::find($id);
        if (!$id) {
            return response()->json([
                'error' => 'Product Category not found',
            ], 404);
        }
        try {
            $id->update(['isActive' => false]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error deleting category' . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Product Category  deleted succesfully',

        ], 200);
    }
}
