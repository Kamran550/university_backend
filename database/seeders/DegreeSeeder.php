<?php

namespace Database\Seeders;

use App\Models\Degree;
use App\Models\DegreeTranslation;
use Illuminate\Database\Seeder;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $degrees = [
            [
                'name' => "Bachelor's",
                'duration' => 4,
                'translations' => [
                    'EN' => "Bachelor's",
                    'TR' => 'Lisans',
                ],
            ],
            [
                'name' => "Master's",
                'duration' => 2,
                'translations' => [
                    'EN' => "Master's",
                    'TR' => 'Yüksek Lisans',
                ],
            ],
            [
                'name' => 'PhD',
                'duration' => 4,
                'translations' => [
                    'EN' => 'PhD',
                    'TR' => 'Doktora',
                ],
            ],
        ];

        foreach ($degrees as $degreeData) {
            $translations = $degreeData['translations'];
            unset($degreeData['translations']);

            $degree = Degree::firstOrCreate(
                ['name' => $degreeData['name']],
                $degreeData
            );

            // Create translations
            foreach ($translations as $lang => $name) {
                DegreeTranslation::firstOrCreate(
                    [
                        'degree_id' => $degree->id,
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
