<?php

namespace App\Http\Controllers\Export;

use App\Contracts\ExcelExportInterface;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\CashTransaction;
use App\Repositories\ExportRepository;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CashTransactionReportController extends Controller implements ExcelExportInterface
{
    const FILE_NAME = 'Laporan BPP - ';

    public function __invoke(string $start_date, string $end_date)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $this->setExcelHeader($spreadsheet);

        // $cash_transaction_results = CashTransaction::select('user_id', 'student_id', 'amount', 'paid_on', 'is_paid')
        //     ->with('students', 'users')
        //     ->whereBetween('paid_on', [date('Y-m-d', strtotime($start_date)), date('Y-m-d', strtotime($end_date))])
        //     ->latest()
        // ->get();

        $cash_transaction_results = Bill::select('student_id', 'billings', 'recent_bill', 'status' ,'updated_at')
            ->with('students')->whereBetween('updated_at', [date('Y-m-d', strtotime($start_date)), date('Y-m-d', strtotime($end_date))])
        ->latest()->get();

        $this->setExcelContent($cash_transaction_results, $sheet);

        ExportRepository::outputTheExcel($spreadsheet, self::FILE_NAME);
    }

    /**
     * Menyiapkan isi header untuk excelnya.
     *
     * @param \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet
     * @return \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
     */
    public function setExcelHeader(Spreadsheet $spreadsheet): Worksheet
    {
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Nama Lengkap');
        $sheet->setCellValue('D1', 'NIS');
        $sheet->setCellValue('E1', 'Kelas');
        $sheet->setCellValue('F1', 'Jurusan');
        $sheet->setCellValue('G1', 'Angkatan');
        $sheet->setCellValue('H1', 'Telah Lunas');
        $sheet->setCellValue('I1', 'Sisa Tagihan');
        $sheet->setCellValue('J1', 'Status ');

        foreach (range('A', 'J') as $paragraph) {
            $sheet->getColumnDimension($paragraph)->setAutoSize(true);
        }

        return $sheet;
    }

    /**
     * Mengisi konten untuk excel.
     *
     * @param \Illuminate\Database\Eloquent\Collection adalah data yang didapat dari eloquent/query builder.
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet adalah instansiasi dari class Spreadsheet phpoffice.
     * @return \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
     */
    public function setExcelContent(Collection $cash_transaction_results, Worksheet $sheet): Worksheet
    {
        $style = ExportRepository::setStyle();

        $cell = 2;
        foreach ($cash_transaction_results as $key => $row) {
            $sheet->setCellValue('A' . $cell, $key + 1);
            $sheet->setCellValue('B' . $cell, date('d-m-Y', strtotime($row->paid_on)));
            $sheet->setCellValue('C' . $cell, $row->students->name);
            $sheet->setCellValue('D' . $cell, $row->students->student_identification_number);
            $sheet->setCellValue('E' . $cell, $row->students->school_class->name);
            $sheet->setCellValue('F' . $cell, $row->students->school_major->abbreviated_word);
            $sheet->setCellValue('G' . $cell, $row->students->school_year_start);
            $sheet->setCellValue('H' . $cell, $row->recent_bill);
            $sheet->setCellValue('I' . $cell, $row->billings - $row->recent_bill);
            $sheet->setCellValue('J' . $cell, $row->status);
            $sheet->getStyle('A1:J' . $cell)->applyFromArray($style);
            $cell++;
        }

        $sheet->setCellValue('G' . $cell, 'Total')->getStyle('G' . $cell)->applyFromArray($style);
        $sheet->setCellValue('H' . $cell, $cash_transaction_results->sum('amount'))->getStyle('H' . $cell)->applyFromArray($style);

        return $sheet;
    }
}
