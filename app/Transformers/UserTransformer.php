<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    public function transform(User $user): array
    {
        return [
            'identificador' => (int)$user->id,
            'nombre' => (string)$user->name,
            'apellido' => (string)$user->lastname,
            'correo' => (string)$user->email,
            'numero_documento' => (string)$user->number_document,
            'tipo_documento' => (string)$user->type_document,
            'fecha_nacimiento' => (string)$user->birth_date,
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
            'apellido' => 'lastname',
            'correo' => 'email',
            'clave' => 'password',
            'numero_documento' => 'number_document',
            'tipo_documento' => 'type_document',
            'fecha_nacimiento' => 'birth_date',
        ];

        return $attributes[$index] ?? null;
    }

    public static function transformedAttribute($index): ?string
    {
        $attributes = [
            'id' => 'identificador',
            'name' => 'nombre',
            'lastname' => 'apellido',
            'email' => 'correo',
            'password' => 'clave',
            'number_document' => 'numero_documento',
            'type_document' => 'tipo_documento',
            'birth_date' => 'fecha_nacimiento',
        ];

        return $attributes[$index] ?? null;
    }
}
