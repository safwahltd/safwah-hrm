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
            $table->string('employee_type')->nullable();
            $table->text('join')->nullable();
            $table->string('email')->unique();
            $table->string('personal_email')->unique()->nullable();
            $table->bigInteger('mobile')->nullable();
            $table->bigInteger('official_mobile')->nullable();
            $table->bigInteger('emergency_contact')->nullable();
            $table->text('image')->nullable();
            $table->string('location')->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('nationality')->nullable();
            $table->string('religion')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('spouse')->nullable();
            $table->string('father')->nullable();
            $table->string('mother')->nullable();
            $table->string('family_member')->nullable();
            $table->string('passport_or_nid')->nullable();
            $table->string('designation')->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedIn')->nullable();
            $table->string('twitter')->nullable();
            $table->string('github')->nullable();
            $table->text('biography')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('name_of_branch')->nullable();
            $table->string('swift_number')->nullable();
            $table->string('routing_number')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('branch_code')->nullable();
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
