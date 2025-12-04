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
        Schema::create('agency_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->unique()->constrained()->onDelete('cascade');
            
            // Agentlik məlumatı
            $table->string('agency_name', 255);
            $table->string('country', 100);
            $table->string('city', 100);
            $table->text('address');
            $table->string('website', 255)->nullable();
            
            // Əlaqə şəxsi
            $table->string('contact_name', 100);
            $table->string('contact_phone', 20);
            $table->string('contact_email', 255);
            
            // Sənədlər
            $table->string('business_license_path', 255)->nullable();
            $table->string('company_logo_path', 255)->nullable();
            
            $table->softDeletes();
            $table->timestamps();
            
            // Indexes
            $table->index('agency_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_applications');
    }
};
