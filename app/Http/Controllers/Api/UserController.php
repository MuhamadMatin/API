<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ApiResourceFailed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ApiResourceSuccess;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(100);

        if (!$users) {
            return new ApiResourceFailed(null, 'Empty users list', 404);
        }

        return new ApiResourceSuccess($users, 'Show users list', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'id' => 'required|unique:users,id',
            'name' => 'required',
            'username' => 'required',
            'email' => 'sometimes|email',
            'password' => 'sometimes',
            'number_phone' => 'required|numeric|digits_between:10,15',
        ]);

        if ($validators->fails()) {
            return new ApiResourceFailed($validators->errors(), 'Something wrong', 422);
        }

        DB::beginTransaction();
        try {
            if ($request->password) {
                $user = User::create([
                    'id' => strtoupper($request->id),
                    'name' => $request->name,
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'number_phone' => $request->number_phone,
                    'created_at' => now(),
                    'created_by' => Auth::id(),
                    'updated_at' => NULL,
                ]);
            } else {
                $user = User::create([
                    'id' => strtoupper($request->id),
                    'name' => $request->name,
                    'username' => $request->username,
                    'email' => $request->email,
                    'number_phone' => $request->number_phone,
                    'created_at' => now(),
                    'created_by' => Auth::id(),
                    'updated_at' => NULL,
                ]);
            }

            DB::commit();
            return new ApiResourceSuccess(null, 'Insert user success', 200);
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
        $user = User::with('services')->where('id', $id)->get();

        if (!$user) {
            return new ApiResourceFailed(null, 'User not found', 404);
        }

        return new ApiResourceSuccess($user, 'Show user', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validators = Validator::make($request->all(), [
            // 'id' => 'required|unique:users,id',
            'name' => 'sometimes',
            'username' => 'sometimes',
            'email' => 'sometimes|email',
            'password' => 'sometimes',
            'number_phone' => 'sometimes|numeric|digits_between:10,15',
        ]);

        if ($validators->fails()) {
            return new ApiResourceFailed($validators->errors(), 'Something wrong', 422);
        }

        DB::beginTransaction();
        try {

            $user = User::find($id);

            if (!$user) {
                return new ApiResourceFailed(null, 'User not found', 404);
            }

            $user->updated_at = now();
            $user->updated_by = Auth::id();
            $user->save();
            $user->update($request->all());

            DB::commit();
            return new ApiResourceSuccess(null, 'Update user success', 200);
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
            $user = User::find($id);

            if (!$user) {
                return new ApiResourceFailed(null, 'User not found', 404);
            }

            $user->deleted_at = now();
            $user->deleted_by = Auth::id();
            $user->save();
            $user->delete();

            DB::commit();
            return new ApiResourceSuccess(null, 'Delete success', 200);
        } catch (\Throwable $e) {
            DB::rollback();
            return new ApiResourceFailed($e, 'Something wrong', 400);
        }
    }
}
