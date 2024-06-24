<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        return response()->json([
            'message' => 'Hello world'
        ], 200);
    }
}