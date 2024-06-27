<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTransactionDetailRequest;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionDetailRequest;

class TransactionDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreTransactionDetailRequest $request)
    {
        $validatedData = $request->input();
        try {
            // Start a database transaction
            DB::beginTransaction();
    
            // Generate UUID for the transaction
            $uuid = Uuid::uuid4()->toString();
        
         
            //Access transaction controller
            $newTransaction = new TransactionController();

            //Create new array for transaction data
            $newTransactionData = [
                'id' => $uuid,
                'user_id' => $validatedData['user_id'],
                'received_amount' => $validatedData['received_amount'],
                'total_amount' => $validatedData['total_amount'],
                'change_amount' => $validatedData['change_amount'],
            ];
    
            // Call store method in TransactionController
            $newTransaction->store($newTransactionData);
          
            

            // Iterate through products and prepare data
            foreach ($request->products as $product) {
                $amount = (float) ($product['product_quantity'] * $product['product_price']);

                // Create transaction detail record
                TransactionDetail::create([
                    'product_id' => $product['product_id'],
                    'quantity' => $product['product_quantity'],
                    'amount' => $amount,  // Insert the amount as a float
                    'transaction_id' => $uuid
                ]);
            }
            
    
            // Commit the transaction
            DB::commit();
    
            return response()->json([
                'message' => 'Transaction details stored successfully',
                'transaction_id' => $uuid
            ], 200);
    
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollback();
    
            return response()->json([
                'message' => 'Failed to store transaction details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TransactionDetail $transactionDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionDetail $transactionDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionDetailRequest $request, TransactionDetail $transactionDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionDetail $transactionDetail)
    {
        //
    }
}
