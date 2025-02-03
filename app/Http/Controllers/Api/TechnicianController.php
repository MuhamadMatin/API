<?php

namespace App\Http\Controllers\Api;

use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ApiResourceFailed;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ApiResourceSuccess;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $technicians = Technician::with('user', 'counter')->paginate(100);

        if (!$technicians) {
            return new ApiResourceFailed(null, 'Empty technicians list', 404);
        }

        return new ApiResourceSuccess($technicians, 'Show technicians list', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'id' => 'required|unique:technicians,id',
            'user_id' => 'required|exists:users,id',
            'counter_id' => 'required|exists:counters,id',
        ]);

        if ($validators->fails()) {
            return new ApiResourceFailed($validators->errors(), 'Something wrong', 422);
        }

        DB::beginTransaction();
        try {
            $technician = Technician::create([
                'id' => strtoupper($request->id),
                'user_id' => strtoupper($request->user_id),
                'counter_id' => strtoupper($request->counter_id),
                'created_at' => now(),
                'created_by' => Auth::id(),
                'updated_at' => NULL,
            ]);

            DB::commit();
            return new ApiResourceSuccess(null, 'Insert technician success', 200);
        } catch (\Throwable $e) {
            DB::rollback();
            return new ApiResourceFailed($e, 'Something wrong', 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $technician = Technician::with('user', 'counter')->where('id', $id)->get();

        if (!$technician) {
            return new ApiResourceFailed(null, 'Technician not found', 404);
        }

        return new ApiResourceSuccess($technician, 'Show technician', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validators = Validator::make($request->all(), [
            // 'id' => 'required|unique:technicians,id',
            'user_id' => 'required|exists:users,id',
            'counter_id' => 'required|exists:counters,id',
        ]);

        if ($validators->fails()) {
            return new ApiResourceFailed($validators->errors(), 'Something wrong', 422);
        }

        DB::beginTransaction();
        try {
            $technician = Technician::find($id);

            if (!$technician) {
                return new ApiResourceFailed(null, 'Technician not found', 404);
            }

            $technician->updated_at = now();
            $technician->updated_by = Auth::id();
            $technician->save();
            $technician->update($request->all());

            DB::commit();
            return new ApiResourceSuccess($technician, 'Update technician success', 200);
        } catch (\Throwable $e) {
            DB::rollback();
            return new ApiResourceFailed($e, 'Something wrong', 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $technician = Technician::find($id);

            if (!$technician) {
                return new ApiResourceFailed(null, 'Technician not found', 404);
            }

            $technician->deleted_at = now();
            $technician->deleted_by = Auth::id();
            $technician->save();
            $technician->delete();

            DB::commit();
            return new ApiResourceSuccess(null, 'Delete success', 200);
        } catch (\Throwable $e) {
            DB::rollback();
            return new ApiResourceFailed($e, 'Something wrong', 400);
        }
    }
}
