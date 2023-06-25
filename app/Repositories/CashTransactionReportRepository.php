<?php

namespace App\Repositories;

use App\Contracts\CashTransactionReportInterface;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\CashTransaction;
use App\Models\Student;

class CashTransactionReportRepository extends Controller implements CashTransactionReportInterface
{
    public function __construct( private CashTransaction $model, private Bill $bills) {}

    /**
     * Mendapatkan data hasil filter berdasarkan tanggal awal dan tanggal akhir.
     *
     * @param string $start tanggal awal.
     * @param string $end tanggal akhir.
     * @return array
     */
    public function filterByDateStartAndEnd(string $start, string $end): array
    {
        $filteredResult = [];

        $startDate = date('Y-m-d', strtotime($start));
        $endDate = date('Y-m-d',strtotime($end));

        $cashTransactions = $this->model->select('user_id', 'student_id', 'amount', 'paid_on', 'is_paid')
            ->with('students', 'users')->whereBetween('paid_on', [$startDate, $endDate])
        ->latest()->get();

        $report = $this->bills->select('student_id', 'billings', 'recent_bill', 'status' ,'updated_at')
            ->with('students')->whereBetween('updated_at', [$startDate, $endDate])
        ->latest()->get();

        // $filteredResult['cashTransactions'] = $cashTransactions;
        $filteredResult['cashTransactions'] = $report;
        $filteredResult['sumOfAmount'] = $cashTransactions->sum('amount');
        $filteredResult['startDate'] = date('d-m-Y', strtotime($startDate));
        $filteredResult['endDate'] = date('d-m-Y', strtotime($endDate));

        return $filteredResult;
    }

    /**
     * Hitung total dari suatu kolom pada tabel table di database dengan method sum().
     *
     * --------
     * $type = 'thisDay' sum suatu kolom/field dari tabel berdasarkan hari pada hari ini.
     * $type = 'thisWeek' sum suatu kolom/field dari tabel berdasarkan minggu pada minggu ini.
     * $type = 'thisMonth' sum suatu kolom/field dari tabel berdasarkan bulan pada bulan ini.
     * $type = 'thisYear' sum suatu kolom/field dari tabel berdasarkan tahun ini.
     * -------
     *
     * @param string $column adalah kolom/field dari tabel.
     * @param string $type adalah tipe sum yang mau diambil.
     * @return Int
     */
    public function sum(string $column, string $type): Int
    {
        $model = $this->model->select('paid_on', 'amount')
        ->whereYear('paid_on', date('Y'));

        match ($type) {
            'thisDay' => $model->whereDay('paid_on', date('d')),
            'thisMonth' => $model->whereMonth('paid_on', date('m')),
            'thisYear' => $model->whereYear('paid_on', date('Y'))
        };

        return $model->sum($column);
    }
}
