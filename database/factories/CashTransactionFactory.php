<?php

namespace Database\Factories;

use App\Models\CashTransaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CashTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CashTransaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => Str::uuid(),
            'transaction_code' => 'TRANS-'.Str::random(6),
            'bill_id' => mt_rand(1, 2),
            'user_id' => 1,
            'student_id' => mt_rand(1, 2),
            'amount' => 70000,
            'paid_on' => Carbon::createFromDate(date('Y'), mt_rand(1, 12), mt_rand(1, 31)),
            'is_paid' => 'PENDING',
            'note' => mt_rand(0, 1) ? $this->faker->text(20) : '',
        ];
    }
}
