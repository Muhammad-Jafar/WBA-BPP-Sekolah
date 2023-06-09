<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\CashTransaction;
use App\Repositories\CashTransactionRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CashTransactionController extends Controller
{
    private $cashTransactionRepository, $startOfWeek, $endOfWeek;

    public function __construct(CashTransactionRepository $cashTransactionRepository)
    {
        $this->cashTransactionRepository = $cashTransactionRepository;
        $this->startOfWeek = now()->startOfWeek()->format('Y-m-d');
        $this->endOfWeek = now()->endOfWeek()->format('Y-m-d');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(): View|JsonResponse
    {
        $cashTransactions = CashTransaction::with('students:id,name')
            ->select('id', 'transaction_code', 'student_id', 'amount', 'paid_on', 'is_paid', 'note')
            ->get();

        $students = Student::select('id', 'student_identification_number', 'name')
            ->whereDoesntHave('cash_transactions', fn (Builder $query) => $query->select(['paid_on'])
            ->whereBetween('paid_on', [$this->startOfWeek, $this->endOfWeek]))
        ->get();

        if (request()->ajax()) {
            return datatables()->of($cashTransactions)
                ->addIndexColumn()
                ->addColumn('amount', fn ($model) => indonesianCurrency($model->amount))
                ->addColumn('paid_on', fn ($model) => date('d M Y', $model->date))
                ->addColumn('is_paid', 'cash_transactions.datatable.status')
                ->rawColumns(['is_paid'])
                ->toJson();
        }

        $cashTransactionTrashedCount = CashTransaction::onlyTrashed()->count();

        return view('cash_transactions.index', [
            'students' => $students,
            'data' => $this->cashTransactionRepository->results(),
            'cashTransactionTrashedCount' => $cashTransactionTrashedCount
        ]);
    }
}
