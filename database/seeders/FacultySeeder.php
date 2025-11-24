<?php

namespace Database\Seeders;

use App\Models\Degree;
use App\Models\Faculty;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bachelor = Degree::where('name', 'Bachelor')->first();
        $master = Degree::where('name', 'Master')->first();
        $phd = Degree::where('name', 'PhD')->first();

        // Faculties for Bachelor degree
        $bachelorFaculties = [
            'Computer Science',
            'Information Technology',
            'Software Engineering',
            'Computer Engineering',
            'Business Administration',
            'Economics',
            'Finance',
            'Marketing',
            'Accounting',
            'Medicine',
            'Dentistry',
            'Pharmacy',
            'Nursing',
            'Law',
            'International Law',
            'Criminal Law',
            'Engineering',
            'Mechanical Engineering',
            'Electrical Engineering',
            'Civil Engineering',
            'Architecture',
            'Urban Planning',
            'Education',
            'Psychology',
            'Sociology',
            'History',
            'Literature',
            'Linguistics',
            'Mathematics',
            'Physics',
            'Chemistry',
            'Biology',
            'Environmental Science',
        ];

        // Faculties for Master degree
        $masterFaculties = [
            'Advanced Computer Science',
            'Data Science',
            'Cybersecurity',
            'Artificial Intelligence',
            'MBA',
            'Master of Finance',
            'Master of Marketing',
            'Master of Economics',
            'Clinical Medicine',
            'Medical Research',
            'Public Health',
            'Master of Laws (LLM)',
            'International Relations',
            'Advanced Engineering',
            'Project Management',
            'Educational Leadership',
            'Clinical Psychology',
            'Social Work',
            'Journalism',
            'Media Studies',
            'Applied Mathematics',
            'Theoretical Physics',
            'Organic Chemistry',
            'Biotechnology',
        ];

        // Faculties for PhD degree
        $phdFaculties = [
            'Computer Science Research',
            'Advanced AI Research',
            'Quantum Computing',
            'Business Research',
            'Economic Theory',
            'Medical Research',
            'Pharmaceutical Research',
            'Legal Research',
            'Engineering Research',
            'Mathematical Research',
            'Physics Research',
            'Chemistry Research',
            'Biological Research',
            'Environmental Research',
            'Social Sciences Research',
            'Humanities Research',
        ];

        // Create and attach Bachelor faculties
        foreach ($bachelorFaculties as $facultyName) {
            $faculty = Faculty::firstOrCreate(['name' => $facultyName]);
            if ($bachelor && !$faculty->degrees()->where('degree_id', $bachelor->id)->exists()) {
                $faculty->degrees()->attach($bachelor->id);
            }
        }

        // Create and attach Master faculties
        foreach ($masterFaculties as $facultyName) {
            $faculty = Faculty::firstOrCreate(['name' => $facultyName]);
            if ($master && !$faculty->degrees()->where('degree_id', $master->id)->exists()) {
                $faculty->degrees()->attach($master->id);
            }
        }

        // Create and attach PhD faculties
        foreach ($phdFaculties as $facultyName) {
            $faculty = Faculty::firstOrCreate(['name' => $facultyName]);
            if ($phd && !$faculty->degrees()->where('degree_id', $phd->id)->exists()) {
                $faculty->degrees()->attach($phd->id);
            }
        }

        // Some faculties can belong to multiple degrees
        $commonFaculties = [
            'Research Methods',
            'Academic Writing',
            'Statistics',
            'Research Ethics',
        ];

        foreach ($commonFaculties as $facultyName) {
            $faculty = Faculty::firstOrCreate(['name' => $facultyName]);
            
            if ($bachelor && !$faculty->degrees()->where('degree_id', $bachelor->id)->exists()) {
                $faculty->degrees()->attach($bachelor->id);
            }
            if ($master && !$faculty->degrees()->where('degree_id', $master->id)->exists()) {
                $faculty->degrees()->attach($master->id);
            }
            if ($phd && !$faculty->degrees()->where('degree_id', $phd->id)->exists()) {
                $faculty->degrees()->attach($phd->id);
            }
        }
    }
}

