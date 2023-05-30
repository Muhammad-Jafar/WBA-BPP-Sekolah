<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::create([
            'school_major_id' => 1,
            'school_class_id' => 2,
            'student_identification_number' => '10389',
            'name' => 'Susanto',
            'email' => 'susanto@gmail.com',
            'phone_number' => '0877xxxx',
            'gender' => 1,
            'school_year_start' => 2014,
            'school_year_end' => 2017,
            'password' => bcrypt('siswa'),
        ])->assignRole('student')->givePermissionTo(['create', 'read']);

        Student::create([
            'school_major_id' => 2,
            'school_class_id' => 1,
            'student_identification_number' => '10399',
            'name' => 'Susant',
            'email' => 'susanti@gmail.com',
            'phone_number' => '0899xxxx',
            'gender' => 2,
            'school_year_start' => 2014,
            'school_year_end' => 2017,
            'password' => bcrypt('siswa'),
        ])->assignRole('student')->givePermissionTo(['create', 'read']);
    }
}
