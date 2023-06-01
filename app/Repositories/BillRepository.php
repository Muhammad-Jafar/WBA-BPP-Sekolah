<?php

namespace App\Repositories;

use App\Contracts\BillInterface;
use App\Models\Student;
use App\Models\Bill;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class BillRepository extends Controller implements BillInterface
{
   private $model, $students, $startOfSemester, $endOfSemester;

   public function __construct(Bill $model, Student $students) 
   {
      $this->model = $model;
      $this->students = $students;
      $this->startOfSemester = now()->startOfMonth()->format('Y-m-d');
      $this->endOfSemester = now()->endOfMonth()->format('Y-m-d');
   }

   /**
    * Menampilkan progress pembayaran
    * konversi progress ke bentuk desimal
    * @return Float 
    */
   public function countProgress(): Float
   {
      $totalProgress = $this->model->sum('billings');
      $recentProgress = $this->model->sum('recent_bill');
      return ($totalProgress - $recentProgress) / 12 * 100;
   }

   /**
    * Menampilkan total jumlah siswa yang telah lunas semester ini
    * @return object 
    */
   public function countStudentWhoHasBillingsDone(): Int
   {
      $students = $this->students->select('id');
      
      $callback = fn(Builder $query) => $query->select(['status'])->where('status','DONE');
      return $students->whereHas('billings', $callback)->count();
   }

   /**
    * Menampilkan total jumlah siswa yang belum lunas semester ini
    * @return object 
    */
    public function countStudentWhoHasBillingsDoneYet(): Int
    {
      $students = $this->students->select('id');
      
      $callback = fn(Builder $query) => $query->select(['status'])->where('status','NOT YET');
      return $students->whereHas('billings', $callback)->count();
    }

    /**
     * Mengembalikan seluruh data yang dibutuhkan
     *
     * @return array
     */
    public function results(): array
    {
      return [
         'students' => [
            'countStudentWhoHasBillingsDone' => $this->countStudentWhoHasBillingsDone(),
            'countStudentWhoHasBillingsDoneYet' => $this->countStudentWhoHasBillingsDoneYet(),
         ],

      ];
    }
}
