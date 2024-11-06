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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('company_title')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('hotLine')->nullable();
            $table->text('address')->nullable();
            $table->text('logo')->nullable();
            $table->text('favicon')->nullable();
            $table->text('website_link')->nullable();
            $table->text('app_link')->nullable();
            $table->text('ios_link')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_author')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
