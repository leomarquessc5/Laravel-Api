<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(protected User $user) {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     */
    public function index() : object
    {
        $users = $this->user->paginate();

        return response([ 'users' => new UserResource($users), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateUserRequest $request) : object
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);

        $userCreated = $this->user->create($data);
        return response(['user' => new UserResource($userCreated), 'message' => 'Created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->user->findOrFail($id);

        return response([ 'user' => new UserResource($user), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateUserRequest $request, string $id)
    {
        $user = $this->user->findOrFail($id);
        $data = $request->validated();

        if ($request->password) $data['password'] = bcrypt($request->password);

        $user->update($data);

        return response([ 'user' => new UserResource($user), 'message' => 'Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = $this->user->findOrFail($id);
        $user->delete();

        return response(['message' => 'Deleted'], Response::HTTP_NO_CONTENT);
    }
}
