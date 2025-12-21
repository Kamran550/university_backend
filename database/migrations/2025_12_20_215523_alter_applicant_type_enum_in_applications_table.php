<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ApplicationTypeEnum;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $enumValues = implode(',', array_map(
            fn($value) => "'" . addslashes($value) . "'",
            ApplicationTypeEnum::values()
        ));

        DB::statement("
            ALTER TABLE applications 
            MODIFY applicant_type 
            ENUM({$enumValues}) 
            NOT NULL 
            DEFAULT 'student'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $enumValues = implode(',', array_map(
                fn($value) => "'" . addslashes($value) . "'",
                ApplicationTypeEnum::values()
            ));
            
            DB::statement("
                ALTER TABLE applications 
                MODIFY applicant_type 
                ENUM({$enumValues}) 
                NOT NULL 
                DEFAULT 'student'
            ");
        });
    }
};
