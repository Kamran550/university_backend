<?php

namespace App\Livewire\Admin\Degrees;

use Livewire\Component;
use App\Models\Degree;
use App\Models\Faculty;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;

class ExportPriceList extends Component
{
    public $isDownloading = false;

    public function downloadPriceList($language = 'EN')
    {
        try {
            $this->isDownloading = true;
            $language = strtoupper($language);

            // Get all degrees with their faculties and programs
            $degrees = Degree::with([
                'programs' => function ($query) {
                    $query->with(['faculty.translations', 'translations']);
                },
                'translations'
            ])->get();

            // Group programs by faculty for each degree
            $data = [];
            foreach ($degrees as $degree) {
                $degreeName = $degree->getName($language);
                if (empty($degreeName)) {
                    $degreeName = $degree->name; // Fallback to default name
                }

                $degreeData = [
                    'name' => $degreeName,
                    'faculties' => []
                ];

                $facultyGroups = $degree->programs->groupBy('faculty_id');

                foreach ($facultyGroups as $facultyId => $programs) {
                    $faculty = $programs->first()->faculty;
                    $facultyName = $faculty->getName($language);
                    if (empty($facultyName)) {
                        $facultyName = $faculty->name; // Fallback to default name
                    }

                    $degreeData['faculties'][] = [
                        'name' => $facultyName,
                        'programs' => $programs->map(function ($program) use ($language) {
                            $programName = $program->getName($language);
                            if (empty($programName)) {
                                $programName = $program->name; // Fallback to default name
                            }

                            return [
                                'name' => $programName,
                                'price_per_year' => $program->price_per_year,
                                'fall_semester' => 1000, // Default
                                'spring_semester' => 1000 // Default
                            ];
                        })
                    ];
                }

                if (!empty($degreeData['faculties'])) {
                    $data[] = $degreeData;
                }
            }

            // Generate QR code as SVG (no imagick extension required)
            $qrCodeSvg = QrCode::format('svg')->size(100)->generate('https://eipu.edu.pl/en/apply');
            $qrCode = base64_encode($qrCodeSvg);

            // Prepare translations
            $translations = $this->getTranslations($language);

            $pdf = Pdf::loadView('pdfs.price-list', [
                'degrees' => $data,
                'language' => $language,
                'qrCode' => $qrCode,
                'translations' => $translations
            ])->setPaper('a4', 'portrait');

            $fileName = $language === 'TR'
                ? 'EIPU-Fiyat-Listesi-2025.pdf'
                : 'EIPU-Price-List-2025.pdf';

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $fileName, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
        } catch (\Exception $e) {
            $this->isDownloading = false;
            Log::error('PDF Generation Error: ' . $e->getMessage());
            session()->flash('error', 'Error generating PDF: ' . $e->getMessage());
            return null;
        } finally {
            $this->isDownloading = false;
        }
    }

    private function getTranslations($language)
    {
        if ($language === 'TR') {
            return [
                'university_name' => 'AVRUPA ULUSLARARASI BARIŞ ÜNİVERSİTESİ',
                'scan_me' => 'BENI TARA',
                'programs' => 'PROGRAMLAR',
                'academic_year' => 'AKADEMİK YIL 2025/2026',
                'program_name' => 'Program Adı',
                'standard_annual_fee' => 'Standart Yıllık Ücret',
                'fall_semester' => 'Güz Dönemi',
                'spring_semester' => 'Bahar Dönemi',
                'scholarship_10' => '%10 Burs',
                'scholarship_50' => '%50 Burs',
                'for_more_info' => 'DAHA FAZLA BİLGİ İÇİN LÜTFEN BURAYA TIKLAYIN'
            ];
        }

        return [
            'university_name' => 'EUROPEAN INTERNATIONAL PEACE UNIVERSITY',
            'scan_me' => 'SCAN ME',
            'programs' => 'PROGRAMS',
            'academic_year' => 'ACADEMIC YEAR 2025/2026',
            'program_name' => 'Program Name',
            'standard_annual_fee' => 'Standard Annual Fee',
            'fall_semester' => 'Fall Semester',
            'spring_semester' => 'Spring Semester',
            'scholarship_10' => '10% Scholarship',
            'scholarship_50' => '50% Scholarship',
            'for_more_info' => 'FOR MORE INFORMATION PLEASE CLICK HERE'
        ];
    }

    public function render()
    {
        return view('livewire.admin.degrees.export-price-list');
    }
}
