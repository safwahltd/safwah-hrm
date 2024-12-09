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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->decimal('basic_salary', 10, 0);
            $table->decimal('house_rent', 10, 0)->nullable();
            $table->decimal('medical_allowance', 10, 0)->nullable();
            $table->decimal('conveyance_allowance', 10, 0)->nullable();
            $table->decimal('others', 10, 0)->nullable();
            $table->decimal('mobile_allowance', 10, 0)->nullable();
            $table->decimal('bonus', 10, 0)->nullable();
            $table->string('bonus_note')->nullable();
            $table->decimal('meal_deduction', 10, 0)->nullable();
            $table->decimal('income_tax', 10, 0)->nullable();
            $table->decimal('other_deduction', 10, 0)->nullable();
            $table->decimal('attendance_deduction', 10, 0)->nullable();
            $table->json('payment')->nullable();
            $table->json('deduct')->nullable();
            $table->unsignedInteger('month');
            $table->unsignedInteger('year');
            $table->boolean('soft_delete')->default(0);
            $table->boolean('status')->default(1);
            $table->bigInteger('log_id');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
