<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResourceFailed;
use App\Http\Resources\ApiResourceSuccess;

use function Pest\Laravel\json;

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $service = Service::find($id);
            if (!$service) {
                return new ApiResourceFailed($service, 'Service not found', 404);
            }
            $service->delete();

            return new ApiResourceSuccess(null, 'Delete success', 200);
        } catch (\Exception $e) {
            return new ApiResourceFailed($e, 'Errors', 500);
        }
    }
}
