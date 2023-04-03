<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicantRequest;
use App\Models\Applicant;
use App\Transformers\ApplicantTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApplicantController extends ApiController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware('transform.input:' . ApplicantTransformer::class)->only(['store', 'update']);
        $this->middleware('scope:postulant')->only('index', 'store');
    }

    public function index(): JsonResponse
    {
        $applications = Applicant::latest()->get();

        return $this->showAll($applications);
    }

    public function store(ApplicantRequest $applicantRequest): JsonResponse
    {
        DB::beginTransaction();

        try {

            $data = $applicantRequest->all();
            $data['user_id'] = Auth::user()->getAuthIdentifier();
            $data['curriculum_vitae'] = $this->storeFile($applicantRequest);
            $data['status_job'] = true;
            Applicant::create($data);

            DB::commit();

            return $this->showMessage("Te postulaste correctamente", 201);

        } catch (\Exception $exception) {

            DB::rollBack();
            Log::info($exception->getCode());
            Log::info($exception->getMessage());

            return $this->errorResponse('No se pudo crear el trabajo solicitado', $exception->getCode());
        }
    }

    private function storeFile(Request $request): string|null
    {
        if ($request->has('curriculum_vitae')) {
            $file = $request['curriculum_vitae'];
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('public/applicants/cv', $file, $filename);
            return $filename;
        }
        return null;
    }
}
