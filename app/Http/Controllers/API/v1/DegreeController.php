<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Services\DegreeService;
use App\Http\Resources\DegreeResource;
use Illuminate\Http\JsonResponse;


class DegreeController extends Controller
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected DegreeService $degreeService
    ) {
        //
    }

    /**
     * Display a listing of the degrees.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $degrees = $this->degreeService->getAll();

        if (empty($degrees) || $degrees->isEmpty()) {
            return $this->notFoundResponse('No degrees found');
        }

        $resource = DegreeResource::collection($degrees);
        return $this->successResourceResponse($resource, 'Degrees retrieved successfully');
    }

    /**
     * Display a degree by id.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $degree = $this->degreeService->getById($id);

        if (empty($degree)) {
            return $this->notFoundResponse('Degree not found');
        }

        $resource = DegreeResource::make($degree);
        return $this->successResourceItemResponse($resource, 'Degree retrieved successfully');
    }
}
    