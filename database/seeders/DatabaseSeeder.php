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
        $this->call([
            AdminStaffSeeder::class,
            StudentSeeder::class,
        ]);
        
        
        // Question::factory(5)->create()->each(function ($question) {
        //     Assessment::factory(5)->create([
        //         'question_id' => $question->id,
        //     ]);
        // });
    }
}
