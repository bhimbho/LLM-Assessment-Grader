<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::factory()->create([
            'firstname' => 'Dr. A',
            'lastname' => 'Abdulrahim',
            'othername' => null,
            'email' => 'admin@assignment.edu',
            'role' => 'admin',
        ]);

        // Create 4 Staff Users
        User::factory()->create([
            'firstname' => 'M.Y',
            'lastname' => 'Tanko',
            'othername' => '',
            'email' => 'my.tanko@assignment.edu',
            'role' => 'staff',
        ]);

        User::factory()->create([
            'firstname' => 'James',
            'lastname' => 'Anderson',
            'othername' => 'Patrick',
            'email' => 'james.anderson@assignment.edu',
            'role' => 'staff',
        ]);

        User::factory()->create([
            'firstname' => 'Maria',
            'lastname' => 'Garcia',
            'othername' => 'Elena',
            'email' => 'maria.garcia@assignment.edu',
            'role' => 'staff',
        ]);

        User::factory()->create([
            'firstname' => 'Robert',
            'lastname' => 'Martinez',
            'othername' => 'Lee',
            'email' => 'robert.martinez@assignment.edu',
            'role' => 'staff',
        ]);
    }
}

