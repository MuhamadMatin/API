<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ApiResourceFailed;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ApiResourceSuccess;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::with('phone', 'user', 'technician', 'technician.user', 'technician.counter', 'damage', 'sparepart')->paginate(100);

        if (!$services) {
            return new ApiResourceFailed(null, 'Empty services list', 404);
        }

        return new ApiResourceSuccess($services, 'Show services list', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'id' => 'required|unique:spareparts,id',
            'subtotal' => 'required|integer|min:0',
            'total' => 'required|integer|min:0',
            'status' => 'required|in:Service,Waiting Service,Done,Waiting owner',
            'address' => 'required',
            'description' => 'required',
            'phone_id' => 'required|exists:phones,id',
            'user_id' => 'required|exists:users,id',
            'technician_id' => 'required|exists:technicians,id',
            'damage_id' => 'required|exists:damages,id',
            'service_id' => 'required|exists:services,id',
            'sparepart_id' => 'required|exists:spareparts,id',
            'start_waranty' => 'required|date_format:Y-m-d H:i|after:yesterday',
            'end_waranty' => 'required|date_format:Y-m-d H:i|after:start_waranty',
        ]);

        if ($validators->fails()) {
            return new ApiResourceFailed($validators->errors(), 'Something wrong', 422);
        }

        DB::beginTransaction();
        try {
            $service = Service::create([
                'id' => strtoupper($request->id),
                'subtotal' => $request->subtotal,
                'total' => $request->total,
                'status' => $request->status,
                'address' => $request->address,
                'description' => $request->description,
                'phone_id' => $request->phone_id,
                'user_id' => $request->user_id,
                'technician_id' => $request->technician_id,
                'damage_id' => $request->damage_id,
                'service_id' => $request->service_id,
                'sparepart_id' => $request->sparepart_id,
                'start_waranty' => $request->start_waranty,
                'end_waranty' => $request->end_waranty,
                'created_at' => now(),
                'created_by' => Auth::id(),
                'updated_at' => NULL,
            ]);

            DB::commit();
            return new ApiResourceSuccess(null, 'Insert service success', 200);
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
        $service = Service::with('phone', 'user', 'technician', 'technician.user', 'technician.counter', 'damage', 'sparepart')->where('id', $id)->get();

        if (!$service) {
            return new ApiResourceFailed(null, 'Service not found', 404);
        }

        return new ApiResourceSuccess($service, 'Show service', 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validators = Validator::make($request->all(), [
            'id' => 'required|unique:spareparts,id',
            'subtotal' => 'required|integer|min:0',
            'total' => 'required|integer|min:0',
            'status' => 'required|in:Service,Waiting Service,Done,Waiting owner',
            'address' => 'required',
            'description' => 'required',
            'phone_id' => 'required|exists:phones,id',
            'user_id' => 'required|exists:users,id',
            'technician_id' => 'required|exists:technicians,id',
            'damage_id' => 'required|exists:damages,id',
            'service_id' => 'required|exists:services,id',
            'sparepart_id' => 'required|exists:spareparts,id',
            'start_waranty' => 'required|date_format:Y-m-d H:i|after:yesterday',
            'end_waranty' => 'required|date_format:Y-m-d H:i|after:start_waranty',
        ]);

        if ($validators->fails()) {
            return new ApiResourceFailed($validators->errors(), 'Something wrong', 422);
        }

        DB::beginTransaction();
        try {
            $service = Service::find($id);
            if (!$service) {
                return new ApiResourceFailed(null, 'Service not found', 404);
            }

            $service = Service::create([
                'id' => strtoupper($request->id),
                'subtotal' => $request->subtotal,
                'total' => $request->total,
                'status' => $request->status,
                'address' => $request->address,
                'description' => $request->description,
                'phone_id' => $request->phone_id,
                'user_id' => $request->user_id,
                'technician_id' => $request->technician_id,
                'damage_id' => $request->damage_id,
                'service_id' => $request->service_id,
                'sparepart_id' => $request->sparepart_id,
                'start_waranty' => $request->start_waranty,
                'end_waranty' => $request->end_waranty,
                'created_at' => now(),
                'created_by' => Auth::id(),
                'updated_at' => NULL,
            ]);

            DB::commit();
            return new ApiResourceSuccess(null, 'Insert service success', 200);
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
            $service = Service::find($id);
            if (!$service) {
                return new ApiResourceFailed(null, 'Service not found', 404);
            }

            $service->deleted_at = now();
            $service->deleted_by = Auth::id();
            $service->save();
            $service->delete();

            DB::commit();
            return new ApiResourceSuccess(null, 'Delete success', 200);
        } catch (\Throwable $e) {
            return new ApiResourceFailed($e, 'Something wrong', 400);
        }
    }
}
