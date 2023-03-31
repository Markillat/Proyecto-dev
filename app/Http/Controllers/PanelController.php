<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanelController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexListJobs()
    {
        return view('panel.list_jobs');
    }

    public function indexListPostulations()
    {
        return view('panel.list_postulations');
    }

    public function indexCreateJobs()
    {
        return view('panel.create_job');
    }
}
