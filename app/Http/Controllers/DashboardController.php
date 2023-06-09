<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\SchoolMajor;
use App\Models\Student;
use App\Repositories\CashTransactionRepository;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private CashTransactionRepository $cashTransactionRepository) {}

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\View\View
     */
    public function __invoke(): View
    {
        $amountThisMonth = indonesianCurrency($this->cashTransactionRepository->sumAmountBy('month', month: date('m')));

        $latestCashTransactions = $this->cashTransactionRepository
            ->cashTransactionLatest(['id', 'transaction_code', 'student_id', 'user_id', 'amount', 'paid_on', 'is_paid', 'note'], 5);

        return view('dashboard.index', [
            'studentCount' => Student::count(),
            'schoolClassCount' => SchoolClass::count(),
            'schoolMajorCount' => SchoolMajor::count(),
            'amountThisMonth' => $amountThisMonth,
            'latestCashTransactions' => $latestCashTransactions
        ]);
    }
}
