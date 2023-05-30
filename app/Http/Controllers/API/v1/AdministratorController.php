<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdministratorEditResource;
use Symfony\Component\HttpFoundation\Response;

class AdministratorController extends Controller
{
    public function edit(int $id): JsonResponse
    {
        $user = new AdministratorEditResource(User::findOrFail($id));

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $user
        ]);
    }
}
