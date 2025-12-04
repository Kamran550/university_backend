<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Services\ProgramService;
use App\Http\Resources\ProgramResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProgramService $programService
    ) {
        //
    }

    /**
     * Display a listing of the programs.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $programs = $this->programService->getAll();

        if (empty($programs) || $programs->isEmpty()) {
            return $this->notFoundResponse('No programs found');
        }

        $resource = ProgramResource::collection($programs);
        return $this->successResourceResponse($resource, 'Programs retrieved successfully');
    }

    /**
     * Display filtered programs by degree_id and/or faculty_id.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function filter(Request $request): JsonResponse
    {
        $degreeId = $request->query('degree_id') ? (int) $request->query('degree_id') : null;
        $facultyId = $request->query('faculty_id') ? (int) $request->query('faculty_id') : null;

        $programs = $this->programService->getFiltered($degreeId, $facultyId);

        if (empty($programs) || $programs->isEmpty()) {
            return $this->notFoundResponse('No programs found');
        }

        $resource = ProgramResource::collection($programs);
        return $this->successResourceResponse($resource, 'Programs retrieved successfully');
    }

    /**
     * Display a program by id.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $program = $this->programService->getById($id);

        if (empty($program)) {
            return $this->notFoundResponse('Program not found');
        }

        $resource = ProgramResource::make($program);
        return $this->successResourceItemResponse($resource, 'Program retrieved successfully');
    }
}
