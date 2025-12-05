<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the enum column to include 'diploma'
        DB::statement("ALTER TABLE document_verifications MODIFY COLUMN document_type ENUM('acceptance', 'certificate', 'diploma') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum values
        DB::statement("ALTER TABLE document_verifications MODIFY COLUMN document_type ENUM('acceptance', 'certificate') NOT NULL");
    }
};

