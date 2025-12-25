<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\PaymentTypeEnum;
use App\Enums\PaymentStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('payment_type', PaymentTypeEnum::values());
            $table->string('academic_year');
            $table->enum('semester', ['Fall', 'Spring']);
            $table->decimal('amount', 10, 2);
            $table->enum('status', PaymentStatusEnum::values())->default(PaymentStatusEnum::PAID->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
