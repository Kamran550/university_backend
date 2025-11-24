<?php

namespace Database\Seeders;

use App\Models\Degree;
use Illuminate\Database\Seeder;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $degrees = ['Bachelor', 'Master', 'PhD'];

        foreach ($degrees as $degreeName) {
            Degree::create([
                'name' => $degreeName,
            ]);
        }
    }
}

