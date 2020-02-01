<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Engineer;

class EngineerController extends Controller
{
    public function all()
    {
        return response()->json(Engineer::all());
    }

    public function show($id)
    {
        try {
            return response()->json(Engineer::findOrFail($id));
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'engineer_user_name' => 'required|string|unique:engineers|max:255',
                'password' => 'required|string|max:255',
                'engineer_full_name' => 'string|max:255'
            ]);
    
            $engineer = Engineer::create([
                'engineer_user_name' => $request->engineer_user_name,
                'password' => Hash::make($request->password),
                'engineer_full_name' => $request->engineer_full_name
            ]);

            return response()->json($engineer, 201);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $engineer = Engineer::findOrFail($id);
            $engineer->update($request->all());

            return response()->json($engineer, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            Engineer::findOrFail($id)->delete();

            return response()->json('Engineer Deleted Successfully', 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }
}
