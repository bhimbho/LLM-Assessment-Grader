<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Question;
use App\Models\User;
use App\Models\Student;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();
        Student::factory(50)->create();
        
        // Question::factory(5)->create()->each(function ($question) {
        //     Assessment::factory(5)->create([
        //         'question_id' => $question->id,
        //     ]);
        // });

//         1. is php loosely typed or strongly typed?
// 2. what is the latest version of PHP
// 3. phpstorm is a type of what?
    }
}
