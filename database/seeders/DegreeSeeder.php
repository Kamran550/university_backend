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
                'description' => 'Undergraduate',
                'duration' => 4,
                'translations' => [
                    'EN' => [
                        'name' => "Bachelor's",
                        'description' => 'Undergraduate',
                    ],
                    'TR' => [
                        'name' => 'Lisans',
                        'description' => 'Lisans',
                    ],
                ],
            ],
            [
                'name' => "Master's",
                'description' => "Master's Degree (Thesis)",
                'duration' => 2,
                'translations' => [
                    'EN' => [
                        'name' => "Master's",
                        'description' => "Master's Degree (Thesis)",
                    ],
                    'TR' => [
                        'name' => 'Yüksek Lisans',
                        'description' => 'Lisansüstü',
                    ],
                ],
            ],
            [
                'name' => 'PhD',
                'description' => 'Doctorate (PhD)',
                'duration' => 4,
                'translations' => [
                    'EN' => [
                        'name' => 'PhD',
                        'description' => 'Doctorate (PhD)',
                    ],
                    'TR' => [
                        'name' => 'Doktora',
                        'description' => 'Lisansüstü',
                    ],
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
            foreach ($translations as $lang => $translationData) {
                DegreeTranslation::firstOrCreate(
                    [
                        'degree_id' => $degree->id,
                        'language' => $lang,
                    ],
                    [
                        'name' => $translationData['name'],
                        'description' => $translationData['description'],
                    ]
                );
            }
        }
    }
}
