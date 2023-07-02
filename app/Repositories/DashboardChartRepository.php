<?php

namespace App\Repositories;

use App\Contracts\ChartInterface;
use App\Http\Controllers\Controller;
use App\Models\CashTransaction;
use Carbon\Carbon;

class DashboardChartRepository extends Controller implements ChartInterface
{
    public function __construct(private CashTransaction $model) {}

    /**
     * Hitung seluruh kolom amount pada tabel cash_transactions dipisahkan dengan bulan dari 1-12.
     *
     * @return array
     */
    public function sumCashTransactionPerMonths(): array
    {
        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun','jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        $customDate = [7,8,9,10,11,12,1,2,3,4,5,6];
        foreach ($customDate as $i) {
            $cashTransactions = $this->model->select('amount', 'paid_on')
            ->whereMonth('paid_on', $i)
            ->whereYear('paid_on', date('Y'))
        ->sum('amount');

            $results[$months[$i-1]] = $cashTransactions;
        }

        /**
         * Output yang akan dihasilkan seperti dibawah ini
         *
         * $results = [
         *  'jul' => 10000,
         *  'agu' => 10000,
         *  'sep' => 10000,
         *  'okt' => 10000,
         *  'nov' => 10000,
         *  'des' => 10000
         *  'jan' => 10000,
         *  'feb' => 10000,
         *  'mar' => 10000,
         *  'apr' => 10000,
         *  'mei' => 10000,
         *  'jun' => 10000,
         * ];
         *
         */

        return $results;
    }
}
