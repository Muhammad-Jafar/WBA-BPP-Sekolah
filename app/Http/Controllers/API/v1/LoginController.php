<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\StudentLoginResource;

class LoginController extends Controller
{
    public function loginAdmin(Request $request)
    {
        if (!$token = auth()->guard('admin')->attempt($request->only('email', 'password'))) {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Unathorized',
            ]);
        }

        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => 'Success to login',
            'token' => $token
        ]);

    }

    public function loginStudent(Request $request)
    {
        if (!$token = auth()->guard('student')->attempt($request->only('email', 'password'))) {
            return response()->json([
                'error' => true,
                'message' => 'Unathorized',
            ]);
        }

        $data = new StudentLoginResource(auth()->guard('student')->user());
        $data['token'] = $token;

        return response()->json([
            'error' => false,
            'message' => 'Success to login',
            'loginResult' => $data,
        ]);

    }
}
