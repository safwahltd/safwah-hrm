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
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('name');
            $table->string('employee_id')->nullable()->unique();
            $table->text('join')->nullable();
            $table->string('email')->unique();
            $table->integer('mobile')->nullable();
            $table->text('image')->nullable();
            $table->string('location')->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('designation')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedIn')->nullable();
            $table->string('twitter')->nullable();
            $table->string('github')->nullable();
            $table->text('biography')->nullable();
            $table->string('token')->nullable();
            $table->dateTime('token_expired_at')->nullable();
            $table->string('otp',10)->nullable();
            $table->string('otp_expired_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
