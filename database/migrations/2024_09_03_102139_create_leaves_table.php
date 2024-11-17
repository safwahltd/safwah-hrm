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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('leave_type');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('dates')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->bigInteger('days_taken')->nullable();
            $table->bigInteger('approved_by')->nullable();
            $table->longText('reason')->nullable();
            $table->text('address_contact')->nullable();
            $table->string('concern_person')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('soft_delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
