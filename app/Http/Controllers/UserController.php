<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['store']);
        $this->middleware('auth:api')->except(['store']);
        $this->middleware('scope:admin')->only('*');
        $this->middleware('can:viewUsers,' . User::class)->only('index');
        $this->middleware('can:createUser,' . User::class)->only('store');
        $this->middleware('can:showUser,' . User::class)->only('show');
    }

    public function index(): JsonResponse
    {
        $users = User::all();

        return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): JsonResponse
    {
        $field = $request->all();
        $field['password'] = bcrypt($request['password']);
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
}
