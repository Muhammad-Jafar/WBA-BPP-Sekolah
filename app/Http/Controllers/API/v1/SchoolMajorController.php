<?php

namespace App\Http\Controllers\API\v1;

use App\Models\SchoolMajor;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\SchoolMajorEditResource;
use Symfony\Component\HttpFoundation\Response;

class SchoolMajorController extends Controller
{
    public function edit(int $id): JsonResponse
    {
        $school_major = new SchoolMajorEditResource(SchoolMajor::findOrFail($id));

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $school_major
        ]);
    }
}
