<?php

namespace App\Transformers;

use App\Models\Workstation;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class WorkstationTransformer extends TransformerAbstract
{

    public function transform(Workstation $workstation): array
    {
        return [
            'identificador' => (int)$workstation->id,
            'titulo' => (string)$workstation->title,
            'detalles' => (string)$workstation->description,
            'salario' => (float)$workstation->salary,
            'requerimientos' => (string)$workstation->requirements,
            'publicacion' => $workstation->publication_date ? $workstation->publication_date->format('Y-m-d') : Carbon::now()->format('Y-m-d'),
            'cerrado' => $workstation->closing_date ? $workstation->closing_date->format('Y-m-d') : Carbon::now()->format('Y-m-d'),
            'estado' => $workstation->status,
            'cantidadPostulantes' => count($workstation->applicants),
            'postulantes' => $workstation->applicants()->get()->transform(function ($row) {
                return [
                    'nombre' => $row->user->name
                ];
            }),
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('workstations.show', $workstation->id)
                ]
            ]
        ];
    }

    public static function originalAttributes($index): ?string
    {
        $attributes = [
            'identificador' => 'id',
            'titulo' => 'title',
            'detalles' => 'description',
            'salario' => 'salary',
            'requerimientos' => 'requirements',
            'publicacion' => 'publication_date',
            'cerrado' => 'closing_date',
            'estado' => 'status'
        ];

        return $attributes[$index] ?? null;
    }

    public static function transformedAttribute($index): ?string
    {
        $attributes = [
            'id' => 'identificador',
            'title' => 'titulo',
            'description' => 'detalles',
            'salary' => 'salario',
            'requirements' => 'requerimientos',
            'publication_date' => 'publicacion',
            'closing_date' => 'cerrado',
            'status' => 'estado'
        ];

        return $attributes[$index] ?? null;
    }
}
