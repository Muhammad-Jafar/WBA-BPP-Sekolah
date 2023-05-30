<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 5; $i++)
        {
            SchoolClass::create(['name' => 'X MIA ' . $i]);

            SchoolClass::create(['name' => 'XI MIA ' . $i]);

            SchoolClass::create(['name' => 'XII MIA ' . $i]);

            SchoolClass::create(['name' => 'X ISS ' . $i]);
        }

        for($i = 1; $i <= 4; $i++)
        {
            SchoolClass::create(['name' => 'XI ISS ' . $i]);

            SchoolClass::create(['name' => 'XII ISS ' . $i]);
        }
    }
}
