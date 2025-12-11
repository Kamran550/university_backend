<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\ProgramTranslation;
use App\Models\ProgramStudyLanguage;
use App\Models\Faculty;
use App\Models\Degree;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        // Standard annual fee is €4,000 for all programs
        $standardPrice = 4000;

        // Bachelor's Programs
        $bachelorsPrograms = [
            'Faculty of Management Sciences' => [
                ['en' => 'Aviation Management', 'tr' => 'Havacılık Yönetimi'],
                ['en' => 'Business Administration', 'tr' => 'İşletme'],
                ['en' => 'Political Science and Public Administration', 'tr' => 'Siyaset Bilimi ve Kamu Yönetimi'],
                ['en' => 'International Relations', 'tr' => 'Uluslararası İlişkiler'],
                ['en' => 'International Business and Entrepreneurship', 'tr' => 'Uluslararası İşletmecilik ve Girişimcilik'],
                ['en' => 'International Trade and Logistics', 'tr' => 'Uluslararası Ticaret ve Lojistik'],
                ['en' => 'Management Information Systems', 'tr' => 'Yönetim Bilişim Sistemleri'],
                ['en' => 'Economics and Finance', 'tr' => 'Ekonomi ve Finans'],
            ],
            'Faculty of Health Sciences' => [
                ['en' => 'Exercise and Sports Sciences', 'tr' => 'Egzersiz ve Spor Bilimleri'],
                ['en' => 'Exercise and Sports Sciences for People with Disabilities', 'tr' => 'Engellilerde Egzersiz ve Spor Bilimleri'],
                ['en' => 'Health Management', 'tr' => 'Sağlık Yönetimi'],
                ['en' => 'Cosmetology', 'tr' => 'Kozmetoloji'],
                ['en' => 'Psychology', 'tr' => 'Psikoloji'],
            ],
            'Faculty of Engineering' => [
                ['en' => 'Computer Engineering', 'tr' => 'Bilgisayar Mühendisliği'],
                ['en' => 'Software Engineering', 'tr' => 'Yazılım Mühendisliği'],
                ['en' => 'Cyber Security Engineering', 'tr' => 'Siber Güvenlik Mühendisliği'],
                ['en' => 'Artificial Intelligence Engineering', 'tr' => 'Yapay Zeka Mühendisliği'],
                ['en' => 'Aviation Systems and Technologies Engineering', 'tr' => 'Havacılık Sistemleri ve Teknolojileri Mühendisliği'],
                ['en' => 'Industrial Engineering', 'tr' => 'Endüstri Mühendisliği'],
                ['en' => 'Management Engineering', 'tr' => 'İşletme Mühendisliği'],
            ],
            'Faculty of Law' => [
                ['en' => 'Law', 'tr' => 'Hukuk'],
            ],
        ];

        // Master's Programs
        $mastersPrograms = [
            'Faculty of Health Sciences' => [
                ['en' => 'Physical Activity Health and Sports', 'tr' => 'Fiziksel Aktivite Sağlık ve Spor'],
                ['en' => 'Health Management', 'tr' => 'Sağlık Yönetimi'],
                ['en' => 'Clinical Psychology', 'tr' => 'Klinik Psikoloji'],
            ],
            'Faculty of Engineering' => [
                ['en' => 'Aviation Systems and Technologies', 'tr' => 'Havacılık Sistemleri ve Teknolojileri'],
                ['en' => 'Engineering Management', 'tr' => 'Mühendislik Yönetimi'],
                ['en' => 'Quality and Compliance Assessment Engineering', 'tr' => 'Kalite ve Uygunluk Değerlendirme Mühendisliği'],
                ['en' => 'Cybersecurity Engineering', 'tr' => 'Siber Güvenlik Mühendisliği'],
                ['en' => 'Software Engineering', 'tr' => 'Yazılım Mühendisliği'],
                ['en' => 'Renewable Energy Engineering', 'tr' => 'Yenilenebilir Enerji Mühendisliği'],
                ['en' => 'Data Science Engineering', 'tr' => 'Veri Bilimi Mühendisliği'],
                ['en' => 'Computer Engineering', 'tr' => 'Bilgisayar Mühendisliği'],
                ['en' => 'Artificial Intelligence Engineering', 'tr' => 'Yapay Zekâ Mühendisliği'],
            ],
            'Faculty of Management Sciences' => [
                ['en' => 'Business Administration (MBA)', 'tr' => 'İşletme (MBA)'],
                ['en' => 'Management Information Systems', 'tr' => 'Yönetim Bilişim Sistemleri'],
            ],
            'Faculty of Law' => [
                ['en' => 'Law', 'tr' => 'Hukuk'],
            ],
        ];

        // PhD Programs
        $phdPrograms = [
            'Faculty of Engineering' => [
                ['en' => 'Aviation Systems and Technologies', 'tr' => 'Havacılık Sistemleri ve Teknolojileri'],
                ['en' => 'Cyber Security Engineering', 'tr' => 'Siber Güvenlik Mühendisliği'],
                ['en' => 'Software Engineering', 'tr' => 'Yazılım Mühendisliği'],
                ['en' => 'Management Information Systems', 'tr' => 'Yönetim Bilişim Sistemleri'],
                ['en' => 'Management Engineering', 'tr' => 'İşletme Mühendisliği'],
                ['en' => 'Computer Engineering', 'tr' => 'Bilgisayar Mühendisliği'],
                ['en' => 'Artificial Intelligence Engineering', 'tr' => 'Yapay Zekâ Mühendisliği'],
            ],
            'Faculty of Management Sciences' => [
                ['en' => 'Business Administration', 'tr' => 'İşletme'],
                ['en' => 'Management and Organization', 'tr' => 'Yönetim ve Organizasyon'],
            ],
            'Faculty of Health Sciences' => [
                ['en' => 'Sports Health Sciences', 'tr' => 'Spor Sağlık Bilimleri'],
            ],
            'Faculty of Law' => [
                ['en' => 'Law', 'tr' => 'Hukuk'],
            ],
        ];

        // Get degrees
        $bachelorsDegree = Degree::where('name', "Bachelor's")->first();
        $mastersDegree = Degree::where('name', "Master's")->first();
        $phdDegree = Degree::where('name', 'PhD')->first();

        // Create Bachelor's Programs
        $this->createPrograms($bachelorsPrograms, $bachelorsDegree, $standardPrice);

        // Create Master's Programs
        $this->createPrograms($mastersPrograms, $mastersDegree, $standardPrice);

        // Create PhD Programs
        $this->createPrograms($phdPrograms, $phdDegree, $standardPrice);
    }

    private function createPrograms(array $programsByFaculty, Degree $degree, int $price): void
    {
        foreach ($programsByFaculty as $facultyName => $programs) {
            $faculty = Faculty::where('name', $facultyName)->first();

            if (!$faculty) {
                continue;
            }

            foreach ($programs as $programData) {
                // Create program with English name (stored in main table)
                $program = Program::firstOrCreate(
                    [
                        'degree_id' => $degree->id,
                        'faculty_id' => $faculty->id,
                        'name' => $programData['en'],
                    ],
                    [
                        'price_per_year' => $price,
                    ]
                );

                // Create English translation
                ProgramTranslation::firstOrCreate(
                    [
                        'program_id' => $program->id,
                        'language' => 'EN',
                    ],
                    [
                        'name' => $programData['en'],
                    ]
                );

                // Create Turkish translation
                ProgramTranslation::firstOrCreate(
                    [
                        'program_id' => $program->id,
                        'language' => 'TR',
                    ],
                    [
                        'name' => $programData['tr'],
                    ]
                );

                // Create study languages (both EN and TR are available for all programs)
                ProgramStudyLanguage::firstOrCreate(
                    [
                        'program_id' => $program->id,
                        'language' => 'EN',
                    ],
                    [
                        'is_available' => true,
                    ]
                );

                ProgramStudyLanguage::firstOrCreate(
                    [
                        'program_id' => $program->id,
                        'language' => 'TR',
                    ],
                    [
                        'is_available' => true,
                    ]
                );
            }
        }
    }
}
