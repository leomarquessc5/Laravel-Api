<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUserRequest;
use App\Models\User;

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

        return $users;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateUserRequest $request) : object
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);

        $userCreated = $this->user->create($data);
        return $userCreated;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateUserRequest $request, string $id)
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
