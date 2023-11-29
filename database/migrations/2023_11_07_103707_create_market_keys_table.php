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
        Schema::create('market_keys', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('message_sign_text');
            $table->longText('message_sign_pgp');
            $table->longText('public_key')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_keys');
    }
};
