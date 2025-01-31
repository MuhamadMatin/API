<?php

namespace App\Http\Controllers\Api;

use App\Models\Technician;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResourceFailed;
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
