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
        Schema::create('tvs', function (Blueprint $table) {
            $table->id();
            $table->string('channel');
            $table->time('time');
            $table->integer('cost');
            $table->integer('advertising_period');
            $table->foreignId('campaign_id')->constrained('campaigns')->cascade();
            $table->integer('expected_revenue');
            $table->integer('actual_revenue')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tvs');
    }
};
