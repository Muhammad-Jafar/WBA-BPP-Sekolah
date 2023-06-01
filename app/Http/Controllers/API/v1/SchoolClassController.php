<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SchoolClassEditResource;
use App\Models\SchoolClass;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SchoolClassController extends Controller
{
    public function edit(int $id): JsonResponse
    {
        $school_class = new SchoolClassEditResource(SchoolClass::findOrFail($id));

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $school_class
        ]);
    }
}
