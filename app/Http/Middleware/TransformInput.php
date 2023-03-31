<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TransformInput
{

    public function handle(Request $request, Closure $next, $transformer)
    {
        $transformerInput = [];

        foreach ($request->all() as $input => $value) {
            $transformerInput[$transformer::originalAttributes($input)] = $value;
        }

        $request->replace($transformerInput);

        $response = $next($request);

        if (isset($response->exception) && $response->exception instanceof ValidationException) {
            $data = $response->getData();
            $transformedErrors = [];

            foreach ($data->error as $field => $error) {
                $transformerField = $transformer::transformedAttribute($field);
                $transformedErrors[$transformerField] = str_replace($field, $transformerField, $error);
            }
            $data->error = $transformedErrors;

            $response->setData($data);
        }

        return $response;
    }
}
