<?php

namespace App\Transformers;

use App\Models\Applicant;
use League\Fractal\TransformerAbstract;

class ApplicantTransformer extends TransformerAbstract
{

    public function transform(Applicant $applicant): array
    {
        return [
            'identificador' => $applicant->id,
            'usuarioId' => $applicant->user_id,
            'nombreCompleto' => $applicant->fullName,
            'trabajoPostulado' => $applicant->workstation->title ?? null,
            'mensaje' => $applicant->message,
            'cv' => $applicant->curriculum_vitae,
            'estado' => $applicant->status_job,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('applications.show', $applicant->id)
                ]
            ]
        ];
    }

    public static function originalAttributes($index): ?string
    {
        $attributes = [
            'identificador' => 'id',
            'usuario' => 'user_id',
            'trabajo' => 'workstation_id',
            'mensaje' => 'message',
            'cv' => 'curriculum_vitae',
            'estado' => 'status_job',
        ];

        return $attributes[$index] ?? null;
    }

    public static function transformedAttribute($index): ?string
    {
        $attributes = [
            'id' => 'identificador',
            'user_id' => 'usuario',
            'workstation_id' => 'trabajo',
            'message' => 'mensaje',
            'curriculum_vitae' => 'cv',
            'status_job' => 'estado',
        ];

        return $attributes[$index] ?? null;
    }
}
