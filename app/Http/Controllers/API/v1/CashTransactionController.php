<?php

namespace App\Http\Controllers\API\v1;

use App\Contracts\APIInterface;
use App\Models\CashTransaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionStoreRequest;
use App\Http\Resources\CashTransactionEditResource;
use App\Http\Resources\CashTransactionShowResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;


class CashTransactionController extends Controller implements APIInterface
{
    public function pay(TransactionStoreRequest $request): JsonResponse
    {
        if ($request->validate())
        {
            CashTransaction::create([
                'transaction_id' => 'TRANS-'.Str::random(6),
                'student_id' => $request->$student_id,
                'amount' => $request->amount,
                'paid_on' => $request->paid_on,
                'note' => $request->note,
            ]);
        }
        else {
            return response()->json([
                'error' => true,
                'message' => "Invalid data passed to"
            ]);
        }

        return response()->json([
            'amount' => $request->amount,

        ]);
    }

    public function show(int $id): JsonResponse
    {
        $cash_transactions = new CashTransactionShowResource(CashTransaction::with('students:id,name', 'users:id,name')->findOrFail($id));

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $cash_transactions
        ]);
    }

    public function edit(int $id): JsonResponse
    {
        $cash_transactions = new CashTransactionEditResource(CashTransaction::with('students:id,name', 'users:id,name')->findOrFail($id));

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $cash_transactions
        ]);
    }
}
