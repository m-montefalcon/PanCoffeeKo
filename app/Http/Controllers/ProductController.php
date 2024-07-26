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
            'products' => $products,
            'meta' => [
                'last_page' => $products->lastPage(), // Total number of pages
            ],
        ], 200);
    }


public function store(StoreProductRequest $request)
{
    // Validate the incoming request (including file upload)
    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
    ]);

    // Extract validated form data
    $validatedData = $request->validated();

    // Store the uploaded file
    $validatedData['image_url'] = $request->file('photo')->store('uploads', 'public');

    // Convert price to float (if needed)
    $validatedData['price'] = floatval($validatedData['price']);

    try {
        // Create a new Product instance and store in the database
        $product = Product::create($validatedData);

        // Return a JSON response with the created product data
        return response()->json([
            'data' => $product,
            'message' => 'Product created successfully'
        ], 200);
    } catch (\Exception $e) {
        // Handle any errors that occur during product creation
        return response()->json([
            'error' => 'Error inserting product to database: ' . $e->getMessage()
        ], 500);
    }
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
    public function show($id)
    {
        try {
            //code...
            $suppliers = Supplier::getSuppliers();
            $categories = ProductCategory::getProducts();
            $product = Product::showProduct($id);
        } catch (\Exception $e) {
           return response()->json([
                'error' => 'Product not found',
            ], 404);
        }

        return response()->json([
                'product' => $product,
                'suppliers' => $suppliers,
                'categories' => $categories
            ], 200);

        
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
