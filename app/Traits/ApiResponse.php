<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait ApiResponse
{
    public function successResponse($data, $code): JsonResponse
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code): JsonResponse
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200): JsonResponse
    {
        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }

        $transformer = $collection->first()->transformer;

        $collection = $this->filterData($collection, $transformer);
        $collection = $this->sortData($collection, $transformer);
        $collection = $this->paginate($collection);
        $collection = $this->transformData($collection, $transformer);

        return $this->successResponse($collection, $code);
    }

    protected function showOne(Model $instance, $code = 200): JsonResponse
    {
        $transformer = $instance->transformer;

        $data = $this->transformData($instance, $transformer);

        return $this->successResponse($data, $code);
    }

    protected function filterData(Collection $collection, $transformer)
    {
        foreach (request()->query() as $query => $value) {
            $attribute = $transformer::originalAttributes($query);
            if (isset($attribute, $value)) {
                $collection = $collection->where($attribute, $value);
            }
        }
        return $collection;
    }

    protected function paginate(Collection $collection): LengthAwarePaginator
    {
        $rules = [
            'per_page' => 'integer|min:2|max:50'
        ];

        $this->validate(request(), $rules);

        $page = LengthAwarePaginator::resolveCurrentPage();

        if (request()->has('per_page')) {
            $perPage = request()->per_page;
        } else {
            $perPage = 15;
        }

        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPage()
        ]);

        $paginated->appends(request()->all());

        return $paginated;
    }

    protected function showMessage($message, $code = 200): JsonResponse
    {
        return $this->successResponse(['data' => $message], $code);
    }

    protected function sortData(Collection $collection, $transformer)
    {
        if (request()->has('sort_by')) {
            $attribute = $transformer::originalAttributes(request()->sort_by);

            $collection = $collection->sortBy->{$attribute};
        }
        return $collection;
    }

    protected function transformData($data, $transformer): ?array
    {
        $transformation = fractal($data, new $transformer);

        return $transformation->toArray();
    }
}
