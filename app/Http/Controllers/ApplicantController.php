<?php

namespace App\Http\Controllers;

use App\Models\Applicant;

class ApplicantController extends ApiController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware('scope:read-postulations')->only('index');
    }

    public function index()
    {
        $applications = Applicant::all();

        return $this->showAll($applications);
    }
}
