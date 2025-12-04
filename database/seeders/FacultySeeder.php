<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = [
            'Engineering',
            'Computer Science & IT',
            'Business & Economics',
            'Law',
            'Medicine & Health Sciences',
            'Architecture & Civil Engineering',
            'Education',
            'Social Sciences',
            'Humanities',
            'Natural Sciences',
        ];

        foreach ($faculties as $facultyName) {
            Faculty::firstOrCreate(['name' => $facultyName]);
        }
    }
}

