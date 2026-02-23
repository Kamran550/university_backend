<?php

namespace Database\Seeders;

use App\Models\Degree;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\ProgramStudyLanguage;
use App\Models\ProgramTranslation;
use Illuminate\Database\Seeder;

class ProgramThesisSeeder extends Seeder
{
    public function run(): void
    {
        $standardPrice = 4000;

        $mastersWithoutThesisDegree = Degree::where('name', "Master's (Without Thesis)")->first();
        if (!$mastersWithoutThesisDegree) {
            return;
        }

        $programs = [
            'Faculty of Management Sciences' => [
                ['en' => 'Management Information Systems', 'tr' => 'Yönetim Bilişim Sistemleri'],
            ],
        ];

        foreach ($programs as $facultyName => $programList) {
            $faculty = Faculty::where('name', $facultyName)->first();
            if (!$faculty) {
                continue;
            }

            foreach ($programList as $programData) {
                $program = Program::firstOrCreate(
                    [
                        'degree_id' => $mastersWithoutThesisDegree->id,
                        'faculty_id' => $faculty->id,
                        'name' => $programData['en'],
                    ],
                    ['price_per_year' => $standardPrice]
                );

                ProgramTranslation::firstOrCreate(
                    ['program_id' => $program->id, 'language' => 'EN'],
                    ['name' => $programData['en']]
                );

                ProgramTranslation::firstOrCreate(
                    ['program_id' => $program->id, 'language' => 'TR'],
                    ['name' => $programData['tr']]
                );

                ProgramStudyLanguage::firstOrCreate(
                    ['program_id' => $program->id, 'language' => 'EN'],
                    ['is_available' => true]
                );

                ProgramStudyLanguage::firstOrCreate(
                    ['program_id' => $program->id, 'language' => 'TR'],
                    ['is_available' => true]
                );
            }
        }
    }
}