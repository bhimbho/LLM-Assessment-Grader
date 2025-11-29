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
                'firstname' => 'Oluwasina',
                'lastname' => 'Soneye',
                'othername' => 'Abimbola',
                'student_id' => 'U23DLCS30085',
                'email' => 'soneye.o@student.edu',
                'password' => Hash::make('password123'),
            ],
            [
                'firstname' => 'Jane',
                'lastname' => 'Smith',
                'othername' => 'Elizabeth',
                'student_id' => 'U23DLCS4330085',
                'email' => 'jane.smith@student.edu',
                'password' => Hash::make('password123'),
            ],
            [
                'firstname' => 'David',
                'lastname' => 'Johnson',
                'othername' => 'Robert',
                'student_id' => 'U23DLCS4330086',
                'email' => 'david.johnson@student.edu',
                'password' => Hash::make('password123'),
            ],
            [
                'firstname' => 'Sarah',
                'lastname' => 'Williams',
                'othername' => 'Grace',
                'student_id' => 'U23DLCS4330087',
                'email' => 'sarah.williams@student.edu',
                'password' => Hash::make('password123'),
            ],
            [
                'firstname' => 'Michael',
                'lastname' => 'Brown',
                'othername' => 'James',
                'student_id' => 'U23DLCS4330088',
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