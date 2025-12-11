<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\FacultyTranslation;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = [
            [
                'name' => 'Faculty of Management Sciences',
                'translations' => [
                    'EN' => 'Faculty of Management Sciences',
                    'TR' => 'Yönetim Bilimleri Fakültesi',
                ],
            ],
            [
                'name' => 'Faculty of Health Sciences',
                'translations' => [
                    'EN' => 'Faculty of Health Sciences',
                    'TR' => 'Sağlık Bilimleri Fakültesi',
                ],
            ],
            [
                'name' => 'Faculty of Engineering',
                'translations' => [
                    'EN' => 'Faculty of Engineering',
                    'TR' => 'Mühendislik Fakültesi',
                ],
            ],
            [
                'name' => 'Faculty of Law',
                'translations' => [
                    'EN' => 'Faculty of Law',
                    'TR' => 'Hukuk Fakültesi',
                ],
            ],
        ];

        foreach ($faculties as $facultyData) {
            $translations = $facultyData['translations'];
            unset($facultyData['translations']);

            $faculty = Faculty::firstOrCreate(
                ['name' => $facultyData['name']],
                $facultyData
            );

            // Create translations
            foreach ($translations as $lang => $name) {
                FacultyTranslation::firstOrCreate(
                    [
                        'faculty_id' => $faculty->id,
                        'language' => $lang,
                    ],
                    [
                        'name' => $name,
                    ]
                );
            }
        }
    }
}
