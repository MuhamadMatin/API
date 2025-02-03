<?php

namespace App\Http\Controllers\Api;

use App\Models\Damage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResourceFailed;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ApiResourceSuccess;

class DamageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $damages = Damage::paginate(100);

        if (!$damages) {
            return new ApiResourceFailed(null, 'Empty damages list', 404);
        }

        return new ApiResourceSuccess($damages, 'Show damages list', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'price'  => 'required|integer|min:0',
            'condition_description' => 'required'
        ]);

        if ($validators->fails()) {
            return new ApiResourceFailed($validators->errors(), 'Something wrong', 422);
        }

        DB::beginTransaction();
        try {
            $counter = Damage::create([
                'id' => strtoupper($request->id),
                'name' => $request->name,
                'price'  => $request->price,
                'condition_description' => $request->condition_description,
                'updated_at' => NULL,
            ]);
            DB::commit();
            return new ApiResourceSuccess($counter, 'Insert damage success', 200);
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
        $damage = Damage::find($id);

        if (!$damage) {
            return new ApiResourceFailed(null, 'Damage not found', 404);
        }

        return new ApiResourceSuccess($damage, 'Show damage', 200);
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
