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
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('escrow_id')->unsigned()->nullable();
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('mediator_id')->unsigned()->nullable();
            $table->bigInteger('conversation_id')->unsigned();
            $table->enum('status', ['Awaiting Store Reply', 'Awaiting User Reply', 'Awaiting Moderator Reply', 'Full Refund', 'Partial Refund', 'closed'])->default('Awaiting Store Reply');
            $table->enum('winner', ['none', 'store', 'user', 'both'])->default('none');
            $table->timestamps();

            // Foreign key constraints with cascade on update and restrict on delete
            $table->foreign('escrow_id')->references('id')->on('escrows')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('mediator_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('conversation_id')->references('id')->on('conversations')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disputes');
    }
};
