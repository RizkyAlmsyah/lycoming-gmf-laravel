<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOrder;

class JobOrderController extends Controller
{
    public function all()
    {
        return response()->json(JobOrder::all());
    }

    public function show($id)
    {
        try {
            return response()->json(JobOrder::findOrFail($id));
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
                'job_order_name' => 'string|max:255',
            ]);
            
            $job_order = JobOrder::create([
                'job_order_name' => $request->job_order_name,
            ]);

            return response()->json($job_order, 201);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $job_order = JobOrder::findOrFail($id);
            $job_order->update($request->all());

            return response()->json($job_order, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            JobOrder::findOrFail($id)->delete();

            return response()->json('Job Order Deleted Successfully', 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }
}
