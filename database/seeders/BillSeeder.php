<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bill;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 2; $i++)
        {
            Bill::create([
                'student_id' => $i,
                'billings' => 840000,
                'recent_bill' => 0,
                'status' => 'BELUM',
            ]);
        }
    }
}
