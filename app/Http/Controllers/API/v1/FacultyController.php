<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Services\FacultyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\FacultyResource;

class FacultyController extends Controller
{
    /** 
     * Create a new class instance.
     */
    public function __construct(
        protected FacultyService $facultyService
    ) {
        //
    }   

    /**
     * Display a listing of the faculties.
     *
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index()
    {
        $faculties = $this->facultyService->getAll();

        if (empty($faculties) || $faculties->isEmpty()) {
            return $this->notFoundResponse('No faculties found');
        }

        $resource = FacultyResource::collection($faculties);
        return $this->successResourceResponse($resource, 'Faculties retrieved successfully');
    }

    /**
     * Display a faculty by id.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $faculty = $this->facultyService->getById($id);

        if (empty($faculty)) {
            return $this->notFoundResponse('Faculty not found');
        }

        $resource = FacultyResource::make($faculty);
        return $this->successResourceItemResponse($resource, 'Faculty retrieved successfully');
    }
}
