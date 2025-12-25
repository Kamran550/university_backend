<?php

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
        Schema::table('document_verifications', function (Blueprint $table) {
            Schema::table('document_verifications', function (Blueprint $table) {
                $table->dropForeign(['application_id']);
            });

            Schema::table('document_verifications', function (Blueprint $table) {
                $table->foreignId('application_id')
                    ->nullable()
                    ->change();
            });

            Schema::table('document_verifications', function (Blueprint $table) {
                $table->foreign('application_id')
                    ->references('id')
                    ->on('applications')
                    ->nullOnDelete();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_verifications', function (Blueprint $table) {
            //
        });
    }
};
