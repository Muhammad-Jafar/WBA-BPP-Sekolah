<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CashTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CashTransactionFilterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function __invoke(): View|JsonResponse
    {
        $start_date = date('Y-m-d', strtotime(request('start_date')));
        $end_date = date('Y-m-d', strtotime(request('end_date')));

        if (request()->ajax()) {
            return datatables()->of(CashTransaction::with('students:id,name', 'users:id,name')
                ->whereBetween('paid_on', [$start_date, $end_date])->get())
                ->addIndexColumn()
                ->addColumn('amount', fn ($model) => indonesianCurrency($model->amount))
                ->addColumn('paid_on', fn ($model) => date('d-m-Y', strtotime($model->date)))
                ->addColumn('is_paid', 'cash_transactions.datatable.status')
                ->rawColumns(['is_paid'])
                ->toJson();
        }

        return view('cash_transactions.filter.index');
    }
}
