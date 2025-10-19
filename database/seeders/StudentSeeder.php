<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'firstname' => 'John',
                'lastname' => 'Doe',
                'othername' => 'Michael',
                'student_id' => 'STU001',
                'email' => 'john.doe@student.edu',
                'password' => Hash::make('password123'),
            ],
            [
                'firstname' => 'Jane',
                'lastname' => 'Smith',
                'othername' => 'Elizabeth',
                'student_id' => 'STU002',
                'email' => 'jane.smith@student.edu',
                'password' => Hash::make('password123'),
            ],
            [
                'firstname' => 'David',
                'lastname' => 'Johnson',
                'othername' => 'Robert',
                'student_id' => 'STU003',
                'email' => 'david.johnson@student.edu',
                'password' => Hash::make('password123'),
            ],
            [
                'firstname' => 'Sarah',
                'lastname' => 'Williams',
                'othername' => 'Grace',
                'student_id' => 'STU004',
                'email' => 'sarah.williams@student.edu',
                'password' => Hash::make('password123'),
            ],
            [
                'firstname' => 'Michael',
                'lastname' => 'Brown',
                'othername' => 'James',
                'student_id' => 'STU005',
                'email' => 'michael.brown@student.edu',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($students as $studentData) {
            Student::updateOrCreate(
                ['student_id' => $studentData['student_id']],
                $studentData
            );
        }
    }
}