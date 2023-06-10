<?php

namespace App\Http\Controllers\Export;

use App\Contracts\ExcelExportInterface;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Repositories\ExportRepository;
use Illuminate\Database\Eloquent\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BillController extends Controller implements ExcelExportInterface
{
    const FILE_NAME = 'Data tagihan - ';

    public function __invoke()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $this->setExcelHeader($spreadsheet);

        $billings = Bill::with('students:id,name')
        ->select('id', 'student_id', 'billings', 'recent_bill', 'status')
        ->get();

    $this->setExcelContent($billings, $sheet);

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
        $sheet->setCellValue('B1', 'Nama Siswa');
        $sheet->setCellValue('C1', 'Total Tagihan');
        $sheet->setCellValue('D1', 'Total Bayar');
        $sheet->setCellValue('E1', 'Status Pembayaran');

        foreach (range('A', 'E') as $paragraph) {
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
    public function setExcelContent(Collection $cash_transactions, Worksheet $sheet): Worksheet
    {
        $cell = 2;
        foreach ($cash_transactions as $key => $row) {
            $sheet->setCellValue('A' . $cell, $key + 1);
            $sheet->setCellValue('B' . $cell, $row->students->name);
            $sheet->setCellValue('C' . $cell, $row->billings);
            $sheet->setCellValue('D' . $cell, $row->recent_bill);
            $sheet->setCellValue('E' . $cell, $row->status);
            $sheet->getStyle('A1:E' . $cell)->applyFromArray(ExportRepository::setStyle());
            $cell++;
        }

        $sheet->setCellValue('C' . $cell, 'Jumlah');
        $sheet->setCellValue('D' . $cell, $cash_transactions->sum('amount'));
        $sheet->getStyle('C' . $cell)->applyFromArray(ExportRepository::setStyle());
        $sheet->getStyle('D' . $cell)->applyFromArray(ExportRepository::setStyle());
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);

        return $sheet;
    }
}
