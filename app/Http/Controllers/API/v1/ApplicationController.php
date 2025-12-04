<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgencyApplicationRequest;
use App\Http\Requests\StudentApplicationRequest;
use App\Services\ApplicationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ApplicationController extends Controller
{
    public function __construct(
        protected ApplicationService $applicationService
    ) {
        //
    }

    /**
     * Store a student application.
     *
     * @param StudentApplicationRequest $request
     * @return JsonResponse
     */
    public function storeStudent(StudentApplicationRequest $request): JsonResponse
    {
        try {
            Log::info('Student application submitted', $request->validated());
            $application = $this->applicationService->storeStudentApplication($request->validated());

            return $this->successResponse(
                'Student application submitted successfully',
                $application->load('program', 'studentApplication')
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'APPLICATION_ERROR',
                'Failed to submit student application: ' . $e->getMessage(),
                500
            );
        }
    }

    /**
     * Store an agency application.
     *
     * @param AgencyApplicationRequest $request
     * @return JsonResponse
     */
    public function storeAgency(AgencyApplicationRequest $request): JsonResponse
    {
        try {
            $application = $this->applicationService->storeAgencyApplication($request->validated());

            return $this->successResponse(
                'Agency application submitted successfully',
                $application->load('program', 'agencyApplication')
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'APPLICATION_ERROR',
                'Failed to submit agency application: ' . $e->getMessage(),
                500
            );
        }
    }
}
