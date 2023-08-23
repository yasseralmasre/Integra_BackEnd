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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('place');
            $table->string('description');
            $table->string('type');
            $table->integer('cost');
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
        Schema::dropIfExists('real_worlds');
    }
};
