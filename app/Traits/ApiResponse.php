<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    /**
     * Success Response.
     *
     * @param string $message
     * @param mixed|null $data
     * @param int $httpCode
     * @return JsonResponse
     */
    public function successResponse(string $message = '', $data = null, int $httpCode = Response::HTTP_OK): JsonResponse
    {
        $response = [
            'timestamp' => now(),
            'status' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return new JsonResponse($response, $httpCode);
    }

    /**
     * Error Response.
     *
     * @param string $message
     * @param string|null $statusCode
     * @param int $httpCode
     * @return JsonResponse
     */
    public function errorResponse(string $message = '', ?string $statusCode = null, int $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        $response = [
            'timestamp' => now(),
            'status' => false,
            'message' => $message,
        ];

        if ($statusCode !== null) {
            $response['statusCode'] = $statusCode;
        }

        return new JsonResponse($response, $httpCode);
    }

    /**
     * Not Found Response.
     *
     * @param string $message
     * @param string|null $statusCode
     * @return JsonResponse
     */
    public function notFoundResponse(string $message = 'Resource not found', ?string $statusCode = 'NOT_FOUND'): JsonResponse
    {
        return $this->errorResponse($message, $statusCode, Response::HTTP_NOT_FOUND);
    }

    /**
     * Validation Error Response.
     *
     * @param string $message
     * @param array $errors
     * @param string|null $statusCode
     * @return JsonResponse
     */
    public function validationErrorResponse(string $message = 'Validation failed', array $errors = [], ?string $statusCode = 'VALIDATION_ERROR'): JsonResponse
    {
        $response = [
            'timestamp' => now(),
            'status' => false,
            'message' => $message,
            'statusCode' => $statusCode,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return new JsonResponse($response, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Request Error Response with params.
     *
     * @param string $statusCode
     * @param string $message
     * @param array $params
     * @param int $httpCode
     * @return JsonResponse
     */
    public function requestErrorResponse(string $statusCode, string $message = '', array $params = [], int $httpCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $response = [
            'timestamp' => now(),
            'status' => false,
            'statusCode' => $statusCode,
            'message' => $message,
        ];

        if (!empty($params)) {
            $response['params'] = $params;
        }

        return new JsonResponse($response, $httpCode);
    }

    /**
     * Success Response with Resource Collection.
     *
     * @param AnonymousResourceCollection $resource
     * @param string $message
     * @return JsonResponse
     */
    public function successResourceResponse(AnonymousResourceCollection $resource, string $message = 'Data retrieved successfully'): JsonResponse
    {
        return $this->successResponse($message, $resource->resource);
    }

    /**
     * Success Response with Resource.
     *
     * @param mixed $resource
     * @param string $message
     * @return JsonResponse
     */
    public function successResourceItemResponse($resource, string $message = 'Data retrieved successfully'): JsonResponse
    {
        return $this->successResponse($message, $resource->resource ?? $resource);
    }
}
