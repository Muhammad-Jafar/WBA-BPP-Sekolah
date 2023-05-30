<?php

namespace Database\Seeders;

use App\Models\SchoolMajor;
use Illuminate\Database\Seeder;

class SchoolMajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $majors = [
            0 => [
                'name' => 'Matematika dan Ilmu Alam',
                'abbreviated_word' => 'MIA'
            ],
            1 => [
                'name' => 'Ilmu-Ilmu Sosial',
                'abbreviated_word' => 'IIS'
            ]
        ];

        foreach ($majors as $major) {
            SchoolMajor::create([
                'name' => $major['name'],
                'abbreviated_word' => $major['abbreviated_word']
            ]);
        }
    }
}
