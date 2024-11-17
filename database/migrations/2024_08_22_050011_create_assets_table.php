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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('asset_name');
            $table->string('asset_model')->nullable();
            $table->string('asset_id')->unique()->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('purchase_from')->nullable();
            $table->string('warranty')->nullable();
            $table->date('warranty_end')->nullable();
            $table->date('hand_in_date')->nullable();
            $table->date('hand_over_date')->nullable();
            $table->string('condition')->nullable();
            $table->string('value')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('soft_delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
