<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;


trait ApiResponser {

    function successResponse($data, $code = 200)
    {
         return response()->json($data, $code); 
    }

    function errorResponse($message, $code) {

        return response()->json(['error' => ['message' => $message, 'code' => $code]], $code);
    }

    function showOne(Model $instance, $code = 200) {

        return $this->successResponse(['data' => $instance], $code);
    }

    function showOneWithToken(Model $instance, $token, $code = 200) {

        return response()->json(['token' => $token, 'data' => $instance], $code);
    }

    function showAll($collection, $code = 200) {

        if ($collection->isEmpty()) 
        {
            return $this->successResponse(['data' => $collection], $code);
        }
        $collection = $this->paginateCollection($collection);

        return $this->successResponse(['data' => $collection], $code);
    }

    function showMessage($message, $code = 200) {

        return $this->successResponse(['data' => $message], $code);
    }

    function paginateCollection(Collection $collection) {
        
        $rules = [

			'per_page' => 'integer|min:2|max:50'
		];

        Validator::validate(request()->all(), $rules);
        
        $page = LengthAwarePaginator::resolveCurrentPage();

        $perPage = 5;

        if (request()->has('per_page')) {

			$perPage = (int) request()->per_page;
		}

        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [

			'path' => LengthAwarePaginator::resolveCurrentPath(),
		]);

        $paginated->appends(request()->all());
        return $paginated;
    }

}





