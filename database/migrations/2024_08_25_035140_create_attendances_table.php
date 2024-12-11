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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('month')->nullable();
            $table->integer('year')->nullable();
            $table->integer('working_day')->nullable();
            $table->integer('attend')->nullable();
            $table->integer('late')->nullable();
            $table->integer('absent')->nullable();
            $table->text('attachment')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('soft_delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
