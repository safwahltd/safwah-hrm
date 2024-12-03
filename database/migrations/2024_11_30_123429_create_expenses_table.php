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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_type');
            $table->string('receipt_no');
            $table->date('date')->nullable();
            $table->integer('user_id');
            $table->string('advance_payment_type')->nullable();
            $table->string('money_payment_type')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('cheque_bank')->nullable();
            $table->string('cheque_date')->nullable();
            $table->string('mfs_sender_no')->nullable();
            $table->string('mfs_receiver_no')->nullable();
            $table->string('mfs_transaction_no')->nullable();
            $table->string('others')->nullable();
            $table->string('adjusted_receipt_no')->nullable();
            $table->longText('reason')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->bigInteger('payment')->nullable();
            $table->bigInteger('due')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->bigInteger('checked_by')->nullable();
            $table->date('checked_date')->nullable();
            $table->bigInteger('approved_by')->nullable();
            $table->date('approved_date')->nullable();
            $table->bigInteger('received_by')->nullable();
            $table->date('received_date')->nullable();
            $table->tinyInteger('soft_delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
