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
        Schema::create('social_media', function (Blueprint $table) {
            $table->id();
            $table->string('blogger');
            $table->enum('type',['Instagram' , 'Facebook' , 'Snapchat' , 'Whatsapp' ,'Telegram' , 'TikTok' ]);
            $table->string('way');
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
        Schema::dropIfExists('social_media');
    }
};
