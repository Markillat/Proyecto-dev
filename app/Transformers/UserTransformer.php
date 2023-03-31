<?php

namespace App\Transformers;

use App\Models\User;
use App\Models\Workstation;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class UserTransformer  extends TransformerAbstract
{

    public function transform(User $user): array
    {
        return [
            'identificador' => (int)$user->id,
            'nombre' => (string)$user->name,
            'correo' => (string)$user->email,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('users.show', $user->id)
                ]
            ]
        ];
    }

    public static function originalAttributes($index): ?string
    {
        $attributes = [
            'identificador' => 'id',
            'nombre' => 'name',
            'correo' => 'email',
            //'esVerificado' => 'verified',
           // 'esAdministrador' => 'admin',
            //'fechaEliminacion' => 'deleted_at',
            'clave' => 'password'
        ];

        return $attributes[$index] ?? null;
    }

    public static function transformedAttribute($index): ?string
    {
        $attributes = [
            'id' => 'identificador',
            'name' => 'nombre',
            'email' => 'correo',
           // 'verified' => 'esVerificado',
           // 'admin' => 'esAdministrador',
          //  'deleted_at' => 'fechaEliminacion',
            'password' => 'clave'
        ];

        return $attributes[$index] ?? null;
    }
}
