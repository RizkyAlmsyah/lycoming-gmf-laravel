<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $this->validate($request, [
            'engineer_user_name' => 'string|max:255',
            'engineer_password' => 'required|string|max:255',
            'engineer_full_name' => 'string|max:255'
        ]);

        try {
            $engineer = Engineer::create([
                'engineer_user_name' => $request->engineer_user_name,
                'engineer_password' => Hash::make($request->engineer_password),
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

            return response()->json('Engineer Status Deleted Successfully', 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }
}