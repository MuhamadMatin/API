<?php

namespace App\Http\Controllers\Api;

use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ApiResourceFailed;
use Illuminate\Support\Facades\Validator;
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
        $validators = Validator::make($request->all(), [
            'id' => 'required|unique:spareparts,id',
            'name' => 'required',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required',
        ]);

        if ($validators->fails()) {
            return new ApiResourceFailed($validators->errors(), 'Something wrong', 422);
        }

        DB::beginTransaction();
        try {
            $sparepart = Sparepart::create([
                'id' => strtoupper($request->id),
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'description' => $request->description,
                'created_at' => now(),
                'created_by' => Auth::id(),
                'updated_at' => NULL,
            ]);

            DB::commit();
            return new ApiResourceSuccess(null, 'Insert sparepart success', 200);
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
        $validators = Validator::make($request->all(), [
            // 'id' => 'required|unique:spareparts,id',
            'name' => 'required',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required',
        ]);

        if ($validators->fails()) {
            return new ApiResourceFailed($validators->errors(), 'Something wrong', 422);
        }

        DB::beginTransaction();
        try {

            $sparepart = Sparepart::find($id);

            if (!$sparepart) {
                return new ApiResourceFailed(null, 'Sparepart not found', 404);
            }

            $sparepart->updated_at = now();
            $sparepart->updated_by = Auth::id();
            $sparepart->save();
            $sparepart->update($request->all());

            DB::commit();
            return new ApiResourceSuccess(null, 'Update sparepart success', 200);
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
            $sparepart = Sparepart::find($id);

            if (!$sparepart) {
                return new ApiResourceFailed(null, 'Sparepart not found', 404);
            }

            $sparepart->deleted_at = now();
            $sparepart->deleted_by = Auth::id();
            $sparepart->save();
            $sparepart->delete();

            DB::commit();
            return new ApiResourceSuccess(null, 'Delete success', 200);
        } catch (\Throwable $e) {
            DB::rollback();
            return new ApiResourceFailed($e, 'Something wrong', 400);
        }
    }
}
