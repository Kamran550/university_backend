<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Faculty;
use App\Models\Degree;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        // Program list by faculty
        $programs = [

            'Engineering' => [
                'Bachelor' => [
                    ['name' => 'Mechanical Engineering', 'price' => 2500],
                    ['name' => 'Electrical Engineering', 'price' => 2600],
                    ['name' => 'Civil Engineering', 'price' => 2400],
                ],
                'Master' => [
                    ['name' => 'Advanced Engineering', 'price' => 4200],
                    ['name' => 'Robotics Engineering', 'price' => 4500],
                ],
                'PhD' => [
                    ['name' => 'Engineering Research', 'price' => 6000],
                    ['name' => 'Robotics Research', 'price' => 6500],
                ]
            ],

            'Computer Science & IT' => [
                'Bachelor' => [
                    ['name' => 'Computer Science', 'price' => 2200],
                    ['name' => 'Software Engineering', 'price' => 2300],
                    ['name' => 'Information Technology', 'price' => 2100],
                ],
                'Master' => [
                    ['name' => 'Data Science', 'price' => 4500],
                    ['name' => 'Artificial Intelligence', 'price' => 4700],
                    ['name' => 'Cybersecurity', 'price' => 4400],
                ],
                'PhD' => [
                    ['name' => 'Advanced AI Research', 'price' => 6500],
                    ['name' => 'Quantum Computing', 'price' => 7000],
                ]
            ],

            'Business & Economics' => [
                'Bachelor' => [
                    ['name' => 'Business Administration', 'price' => 2000],
                    ['name' => 'Economics', 'price' => 2100],
                    ['name' => 'Finance', 'price' => 2200],
                    ['name' => 'Marketing', 'price' => 2000],
                ],
                'Master' => [
                    ['name' => 'MBA', 'price' => 4500],
                    ['name' => 'Master of Finance', 'price' => 4300],
                    ['name' => 'Master of Marketing', 'price' => 4200],
                ],
                'PhD' => [
                    ['name' => 'Business Research', 'price' => 5500],
                    ['name' => 'Economic Theory', 'price' => 5800],
                ]
            ],

            'Law' => [
                'Bachelor' => [
                    ['name' => 'International Law', 'price' => 2300],
                    ['name' => 'Criminal Law', 'price' => 2400],
                ],
                'Master' => [
                    ['name' => 'Master of Laws (LLM)', 'price' => 4200],
                ],
                'PhD' => [
                    ['name' => 'Legal Research', 'price' => 6000],
                ]
            ],

            'Medicine & Health Sciences' => [
                'Bachelor' => [
                    ['name' => 'Nursing', 'price' => 2500],
                    ['name' => 'Public Health', 'price' => 3000],
                ],
                'Master' => [
                    ['name' => 'Medical Research', 'price' => 4800],
                ],
                'PhD' => [
                    ['name' => 'Clinical Medicine', 'price' => 6500],
                    ['name' => 'Pharmaceutical Research', 'price' => 6800],
                ]
            ],

            'Architecture & Civil Engineering' => [
                'Bachelor' => [
                    ['name' => 'Architecture', 'price' => 2400],
                    ['name' => 'Urban Planning', 'price' => 2200],
                ],
                'Master' => [
                    ['name' => 'Advanced Architecture', 'price' => 4300],
                ],
                'PhD' => [
                    ['name' => 'Civil Engineering Research', 'price' => 6000],
                ]
            ],

            'Education' => [
                'Bachelor' => [
                    ['name' => 'Education Studies', 'price' => 2000],
                ],
                'Master' => [
                    ['name' => 'Educational Leadership', 'price' => 4200],
                ],
                'PhD' => [
                    ['name' => 'Research Methods in Education', 'price' => 5500],
                ]
            ],

            'Social Sciences' => [
                'Bachelor' => [
                    ['name' => 'Psychology', 'price' => 2100],
                    ['name' => 'Sociology', 'price' => 2000],
                ],
                'Master' => [
                    ['name' => 'Clinical Psychology', 'price' => 4300],
                ],
                'PhD' => [
                    ['name' => 'Social Sciences Research', 'price' => 5600],
                ]
            ],

            'Humanities' => [
                'Bachelor' => [
                    ['name' => 'History', 'price' => 2000],
                    ['name' => 'Literature', 'price' => 2000],
                ],
                'Master' => [
                    ['name' => 'Media Studies', 'price' => 4200],
                ],
                'PhD' => [
                    ['name' => 'Humanities Research', 'price' => 5500],
                ]
            ],

            'Natural Sciences' => [
                'Bachelor' => [
                    ['name' => 'Mathematics', 'price' => 2000],
                    ['name' => 'Physics', 'price' => 2100],
                    ['name' => 'Chemistry', 'price' => 2100],
                    ['name' => 'Biology', 'price' => 2100],
                ],
                'Master' => [
                    ['name' => 'Applied Mathematics', 'price' => 4300],
                    ['name' => 'Theoretical Physics', 'price' => 4400],
                    ['name' => 'Organic Chemistry', 'price' => 4200],
                ],
                'PhD' => [
                    ['name' => 'Natural Science Research', 'price' => 6000],
                ]
            ]

        ];

        // Create programs dynamically
        foreach ($programs as $facultyName => $degreePrograms) {

            $faculty = Faculty::where('name', $facultyName)->first();

            foreach ($degreePrograms as $degreeName => $programList) {

                $degree = Degree::where('name', $degreeName)->first();

                foreach ($programList as $program) {
                    Program::firstOrCreate([
                        'name' => $program['name'],
                        'faculty_id' => $faculty->id,
                        'degree_id' => $degree->id,
                    ], [
                        'price_per_year' => $program['price'],
                    ]);
                }
            }
        }
    }
}
