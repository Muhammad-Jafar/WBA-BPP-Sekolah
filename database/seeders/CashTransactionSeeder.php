<?php

namespace Database\Seeders;

use App\Models\CashTransaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CashTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['Susanto', 'Susanti'];

        for ($i=1; $i <= 2; $i++)
        {
            CashTransaction::create([
                'id' => Str::uuid()->toString(),
                'transaction_code' => 'TRANS-'.Str::random(6),
                'bill_id' => $i,
                'user_id' => 1,
                'student_id' => $i,
                'amount' => 70000,
                'paid_on' => Carbon::createFromDate(date('Y'), mt_rand(1, 12), mt_rand(1, 31)),
                'is_paid' => 'PENDING',
                'note' => "Note transactions",
            ]);
        }
        // CashTransaction::factory(4)->create();
    }
}
