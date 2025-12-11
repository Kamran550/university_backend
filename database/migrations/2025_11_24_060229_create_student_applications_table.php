<?php

use App\Enums\GenderEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->unique()->constrained()->onDelete('cascade');
            
            // Şəxsi məlumat
            $table->string('student_number', 20)->unique();
            $table->string('passport_number', 50)->nullable();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('father_name', 100);
            $table->enum('gender', GenderEnum::values())->default(GenderEnum::MALE->value);
            $table->date('date_of_birth');
            $table->string('place_of_birth', 100);
            $table->string('nationality', 100);
            $table->string('native_language', 50);
            
            // Əlaqə
            $table->string('phone', 20);
            $table->string('email', 255);
            
            // Ünvan
            $table->string('country', 100);
            $table->string('city', 100);
            $table->text('address_line');
            
            // Sənədlər (file path-ları)
            $table->string('photo_id_path', 255);
            $table->string('profile_photo_path', 255)->nullable();
            $table->string('diploma_path', 255)->nullable();
            $table->string('transcript_path', 255);
            $table->string('study_language', 50);
            $table->softDeletes();
            $table->timestamps();
            
            // Indexes
            $table->index('email');
            $table->index('student_number');
            $table->index('passport_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_applications');
    }
};
