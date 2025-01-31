<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResourceFailed;
use App\Http\Resources\ApiResourceSuccess;
use Illuminate\Database\Eloquent\Builder;

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id)->with('services')->get();

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
