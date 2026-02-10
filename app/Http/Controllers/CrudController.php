<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CrudController extends Controller
{
    public function index()
    {
        return view('form');
    }
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'number' => 'required',
        ]);
    
        try {
            DB::table('assign')->insert([
                'name' => $request->name,
                'email' => $request->email,
                'number' => $request->number,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            return response()->json([
                'message' => 'Registration successful!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while saving data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

   
}
