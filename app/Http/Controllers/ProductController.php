<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ProductCategory;
use App\Models\Supplier;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::getActiveProducts();
        return response()->json([
            'data' => $products
        ], 200);
    }

   
    public function store(StoreProductRequest $request)
    {
        //Extract validated data
        $validatedData = $request->validated();

        //Inserting product to DB
        try {
            Product::create($validatedData);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error inserting product to database'  . $e->getMessage()
            ], 500);
        }
        return response()->json([
            'data' => $validatedData
        ], 200);
    }

    public function productInformation(){
        $suppliers = Supplier::getSuppliers();
        $categories = ProductCategory::getProducts();
        return response()->json([
            'suppliers' => $suppliers,
            'categories' => $categories
        ], 200);

    }
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request)
    {
        //Extract validated data

        $validatedData = $request->validated();
        $product = Product::find($validatedData['id']);
        if (!$product) {
            return response()->json([
                'error' => 'No product found'
            ], 404);
        }
        try {
            $product->update($validatedData);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error updating product' . $e->getMessage()
            ], 505);
        }
        return response()->json([
            'message' => 'Product updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = Product::find($id);
        if (!$id) {
            return response()->json([
                'error' => 'Product not found',
            ], 404);
        }
        try {
            $id->update(['isActive' => false]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error Product suppliers' . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Product information deleted succesfully',

        ], 200);
    }

    public function stockin(UpdateProductRequest $request)
    {
        //Extract validated request
        $validatedData = $request->validated();

        $product = Product::find($validatedData['id']);
        if (!$product) {
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }
        try {
            //code...
            $product->quantity += $validatedData['quantity'];
            $product->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unable to stock in product' . $e->getMessage()
            ], 505);
        }
        return response()->json([
            'message' => 'Stock in product successfully'
        ], 200);
    }
}
