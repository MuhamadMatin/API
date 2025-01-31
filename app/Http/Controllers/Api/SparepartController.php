<?php

namespace App\Http\Controllers\Api;

use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResourceFailed;
use App\Http\Resources\ApiResourceSuccess;

class SparepartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spareparts = Sparepart::paginate(100);

        if (!$spareparts) {
            return new ApiResourceFailed(null, 'Empty spareparts list', 404);
        }

        return new ApiResourceSuccess($spareparts, 'Show spareparts list', 200);
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
        $sparepart = Sparepart::find($id);

        if (!$sparepart) {
            return new ApiResourceFailed(null, 'Sparepart not found', 404);
        }

        return new ApiResourceSuccess($sparepart, 'Show sparepart', 200);
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
