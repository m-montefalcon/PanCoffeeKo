<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::getActiveSuppliers();
        return response()->json([
            'suppliers' => $suppliers,
            'meta' => [
                'last_page' => $suppliers->lastPage(), // Total number of pages
            ],
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        //Extract the validated data
        $validatedData = $request->validated();

        //Store the data in database
        try {
            $supplier = Supplier::create($validatedData);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create supplier: ' . $e->getMessage(),
            ], 500);
        }
        return response()->json([
            'Message' => 'Create new supplier successfully.'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request)
    {
        //Extract the data
        $validatedData = $request->validated();

        //Find the suppliers data
        $supplier = Supplier::find($validatedData['id']);
        if (!$supplier) {
            return response()->json([
                'error' => 'Supplier not found',
            ], 404);
        }
        try {
            $supplier->update($validatedData);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error updating supplier information' . $e->getMessage(),
            ], 500);
        }
        return response()->json([
            'message' => 'Supplier information update succesfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = Supplier::find($id);
        if (!$id) {
            return response()->json([
                'error' => 'Supplier not found',
            ], 404);
        }
        try {
            $id->update(['isActive' => false]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error deleting suppliers' . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Supplier information deleted succesfully',

        ], 200);
    }
}
