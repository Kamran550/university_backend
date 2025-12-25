<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\DocumentTypeEnum;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('document_verifications', function (Blueprint $table) {
            $table->foreignId('payment_id')->nullable()->after('application_id')->constrained('payments')->onDelete('cascade');
        });

        $enumValues = implode(',', array_map(
            fn($value) => "'" . addslashes($value) . "'",
            DocumentTypeEnum::values()
        ));

        DB::statement("
            ALTER TABLE document_verifications 
            MODIFY document_type 
            ENUM({$enumValues}) 
            NOT NULL 
            DEFAULT 'payment'
        ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_verifications', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
            $table->dropColumn('payment_id');
            $enumValues = implode(',', array_map(
                fn($value) => "'" . addslashes($value) . "'",
                DocumentTypeEnum::values()
            ));

            DB::statement("
                ALTER TABLE document_verifications 
                MODIFY document_type 
                ENUM({$enumValues}) 
                NOT NULL 
                DEFAULT 'payment'
            ");
        });
    }
};
