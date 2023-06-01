<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Bill;
use App\Http\Controllers\Controller;
use App\Http\Resources\BillShowResource;
use Illuminate\Http\JsonResponse;

class BillController extends Controller
{
    public function show(int $id): JsonResponse
    {
        $billings = new BillShowResource(Bill::with('students:id,name')->findOrFail($id));

        return response()->json([
            'error' => false,
            'message' => 'Success get billings',
            'billResult' => $billings
        ]);
    }
}
