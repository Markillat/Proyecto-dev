<?php

namespace App\Transformers;

use App\Models\Applicant;
use League\Fractal\TransformerAbstract;

class ApplicantTransformer extends TransformerAbstract
{

    public function transform(Applicant $applicant): array
    {
        return [
            'identificador' => (int)$applicant->id,
            'usuarioId' => (int)$applicant->user_id,
            'nombreCompleto' => $applicant->user->name,
            'celular' => $applicant->phone,
            'cv' => $applicant->curriculum_vitae,
            'estado' => $applicant->send_Status,
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
            'celular' => 'phone',
            'cv' => 'curriculum_vitae',
            'estado' => 'send_status',
        ];

        return $attributes[$index] ?? null;
    }

    public static function transformedAttribute($index): ?string
    {
        $attributes = [
            'id' => 'identificador',
            'user_id' => 'usuario',
            'phone' => 'celular',
            'curriculum_vitae' => 'cv',
            'send_status' => 'estado',
        ];

        return $attributes[$index] ?? null;
    }
}
