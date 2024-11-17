<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_balances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('sick')->default(0);
            $table->bigInteger('casual')->default(0);
            $table->bigInteger('sick_spent')->default(0);
            $table->bigInteger('casual_spent')->default(0);
            $table->bigInteger('sick_left')->default(0);
            $table->bigInteger('casual_left')->default(0);
            $table->integer('year')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};
