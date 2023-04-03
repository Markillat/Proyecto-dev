<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobRequest;
use App\Models\Workstation;
use App\Traits\ApiResponse;
use App\Transformers\WorkstationTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkStationController extends ApiController
{
    use ApiResponse;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware('transform.input:' . WorkstationTransformer::class)->only(['store', 'update']);
        $this->middleware('scope:postulant,admin')->only('index', 'show');
        $this->middleware('can:createJob,' . Workstation::class)->only('store');
    }

    public function index(): JsonResponse
    {
        $workStations = Workstation::latest()->get();

        return $this->showAll($workStations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateJobRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            Workstation::create($request->all());

            DB::commit();

            return $this->showMessage("Se creo correctamente el trabajo", 201);

        } catch (\Exception $exception) {

            DB::rollBack();
            Log::info($exception->getCode());
            Log::info($exception->getMessage());

            return $this->errorResponse('No se pudo crear el trabajo solicitado', $exception->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Workstation $workstation): JsonResponse
    {
        return $this->showOne($workstation);
    }
}
