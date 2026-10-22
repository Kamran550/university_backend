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
        Schema::table('users', function (Blueprint $table) {
            // TOTP secret, stored encrypted with APP_KEY (see User::casts())
            $table->text('two_factor_secret')->nullable()->after('password');
            // Set once the admin has scanned the QR code and confirmed a valid code
            $table->timestamp('two_factor_confirmed_at')->nullable()->after('two_factor_secret');
            // Last accepted TOTP time-step, prevents re-using the same code (replay)
            $table->unsignedBigInteger('two_factor_last_used_step')->nullable()->after('two_factor_confirmed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['two_factor_secret', 'two_factor_confirmed_at', 'two_factor_last_used_step']);
        });
    }
};
