<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Validated;

use function Laravel\Prompts\password;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    //
    public function index()
    {
        $users =  User::getUsers();
        return response()->json([
            'data' => $users,
        ], 200);

    }

    public function register(StoreUserRequest $request)
    {
        // Process the validated data
        $validatedData = $request->validated();

        //Hash password
        $validatedData['password'] = Hash::make($validatedData['password']);

        //Create user account
        try {
            User::create($validatedData);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create user: ' . $e->getMessage(),
            ], 500);
        }

        // Return a JSON response with the validated data
        return response()->json([
            'message' => 'User registered successfully',
        ], 200);
    }


    public function update(UpdateUserRequest $request)
    {
        // Return a JSON response with the validated data
        $validatedData = $request->validated();

        // Hash password if provided
        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        // Find user in database
        $user = User::find($validatedData['userId']);
        if (!$user) {
            return response()->json([
                'error' => 'User not found',
            ], 404);
        }

        //Update  user account
        try {
            $user->update($validatedData);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update user: ' . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'User information update succesfully',
        ], 200);
    }

    public function softDelete($userId){
        $user = User::find($userId);
        if (!$user) {
            return response()->json([
                'error' => 'User not found',
            ], 404);
        }
        try {
            $user->update(['isEmployed' => false]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to soft delete user: ' . $e->getMessage(),
            ], 500);
        }
        return response()->json([
            'message' => 'User information soft delete succesfully',
        ], 200);
    }
}
