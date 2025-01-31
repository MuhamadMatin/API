<?php

namespace App\Http\Controllers\Api;

use App\Models\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResourceFailed;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ApiResourceSuccess;

class CounterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $counters = Counter::paginate(100);

        if (!$counters) {
            return new ApiResourceFailed(null, 'Empty Counters list', 404);
        }

        return new ApiResourceSuccess($counters, 'Show Counters list', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'id' => 'required',
            'counter_name' => 'required',
            'counter_address' => 'required',
            'counter_phone' => 'required|numeric',
        ]);

        if ($validators->fails()) {
            return new ApiResourceFailed($validators->errors(), 'Something wrong', 422);
        }

        DB::beginTransaction();
        try {
            $counter = Counter::create([
                'id' => strtoupper($request->id),
                'counter_name' => $request->counter_name,
                'counter_address' => $request->counter_address,
                'counter_phone' => $request->counter_phone,
            ]);
            DB::commit();
            return new ApiResourceSuccess($counter, 'Insert counter success', 200);
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
        $counter = Counter::find($id);
        if (!$counter) {
            return new ApiResourceFailed(null, 'Counter not found', 404);
        }

        return new ApiResourceSuccess($counter, 'Show Counter', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validators = Validator::make($request->all(), [
            'id' => 'sometimes',
            'counter_name' => 'sometimes',
            'counter_address' => 'sometimes',
            'counter_phone' => 'sometimes',
        ]);

        if ($validators->fails()) {
            return new ApiResourceFailed($validators->errors(), 'Something wrong', 422);
        }

        DB::beginTransaction();
        try {
            $counter = Counter::find($id);

            if (!$counter) {
                return new ApiResourceFailed(null, 'Counter not found', 404);
            }

            $counter->update($request->all());
            DB::commit();
            return new ApiResourceSuccess($counter, 'Update counter success', 200);
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
            $counter = Counter::find($id);

            if (!$counter) {
                return new ApiResourceFailed(null, 'Counter not found', 404);
            }

            $counter->delete($id);
            DB::commit();
            return new ApiResourceSuccess(null, 'Delete success', 200);
        } catch (\Throwable $e) {
            DB::rollback();
            return new ApiResourceFailed($e, 'Something wrong', 400);
        }
    }
}
