<?php

use App\Enums\ApplicationStatusEnum;
use App\Enums\ApplicationTypeEnum;
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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->enum('applicant_type', ApplicationTypeEnum::values())->default(ApplicationTypeEnum::STUDENT->value);
            
            // Proqram məlumatı
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            // Status
            $table->enum('status', ApplicationStatusEnum::values())->default(ApplicationStatusEnum::PENDING->value);
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('reviewed_at')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable();
            
            // Metadata
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('locale', 5)->default('en');
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
