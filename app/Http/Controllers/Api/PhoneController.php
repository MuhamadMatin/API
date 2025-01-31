<?php

namespace App\Http\Controllers\Api;

use App\Models\Phone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResourceFailed;
use App\Http\Resources\ApiResourceSuccess;

class PhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $phones = Phone::paginate(100);

        if (!$phones) {
            return new ApiResourceFailed(null, 'Empty phones list', 404);
        }

        return new ApiResourceSuccess($phones, 'Show phones list', 200);
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
        $phone = Phone::find($id);

        if (!$phone) {
            return new ApiResourceFailed(null, 'Phone not found', 404);
        }

        return new ApiResourceSuccess($phone, 'Show phone', 200);
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
