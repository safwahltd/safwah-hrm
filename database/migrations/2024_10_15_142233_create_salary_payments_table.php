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
        Schema::create('salary_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('salary_id');
            $table->decimal('paid_amount', 10, 2);
            $table->date('payment_date');
            $table->string('payment_method')->nullable();
            $table->string('payment_reference')->nullable();
            $table->bigInteger('log_id');
            $table->bigInteger('soft_delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_payments');
    }
};
