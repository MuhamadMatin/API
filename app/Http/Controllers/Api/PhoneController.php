<?php

namespace App\Http\Controllers\Api;

use App\Models\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ApiResourceFailed;
use Illuminate\Support\Facades\Validator;
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
        $validators = Validator::make($request->all(), [
            'id' => 'required|unique:phones,id',
            'type_phone' => 'required',
            'merk_phone' => 'required',
        ]);

        if ($validators->fails()) {
            return new ApiResourceFailed($validators->errors(), 'Something wrong', 422);
        }

        DB::beginTransaction();
        try {
            $phone = Phone::create([
                'id' => strtoupper($request->id),
                'type_phone' => $request->type_phone,
                'merk_phone' => $request->merk_phone,
                'created_at' => now(),
                'created_by' => Auth::id(),
                'updated_at' => NULL,
            ]);

            DB::commit();
            return new ApiResourceSuccess(null, 'Insert phone success', 200);
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
        $validators = Validator::make($request->all(), [
            // 'id' => 'required|unique:phones,id',
            'type_phone' => 'required',
            'merk_phone' => 'required',
        ]);

        if ($validators->fails()) {
            return new ApiResourceFailed($validators->errors(), 'Something wrong', 422);
        }

        DB::beginTransaction();
        try {
            $phone = Phone::find($id);

            if (!$phone) {
                return new ApiResourceFailed(null, 'Phone not found', 404);
            }

            $phone->updated_at = now();
            $phone->updated_by = Auth::id();
            $phone->save();
            $phone->update($request->all());

            DB::commit();
            return new ApiResourceSuccess(null, 'Update phone success', 200);
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
            $phone = Phone::find($id);

            if (!$phone) {
                return new ApiResourceFailed(null, 'Phone not found', 404);
            }

            $phone->deleted_at = now();
            $phone->deleted_by = Auth::id();
            $phone->save();
            $phone->delete();

            DB::commit();
            return new ApiResourceSuccess(null, 'Delete success', 200);
        } catch (\Throwable $e) {
            DB::rollback();
            return new ApiResourceFailed($e, 'Something wrong', 400);
        }
    }
}
