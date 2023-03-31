<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['store']);
        $this->middleware('auth:api')->except(['store']);
    }

    public function index()
    {
        $users = User::all();

        return $this->showAll($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): \Illuminate\Http\JsonResponse
    {
        $field = $request->all();
        $field['password'] = bcrypt($request['password']);
        //$field['verified'] = User::USUARIO_NO_VERIFICADO;
        //  $field['verification_token'] = User::generateVerificationToken();
        //$field['admin'] = User::USUARIO_REGULAR;
        $user = User::create($field);

        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        return $this->showOne($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
