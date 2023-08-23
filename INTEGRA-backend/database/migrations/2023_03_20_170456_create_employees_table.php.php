<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->date('dateOfBrith');
            $table->enum('gender', ['Male', 'Female']);
            $table->text('address');
            $table->string('email')->unique();
            $table->string('phone');
            $table->date('dateOfHire');
            $table->integer('salary');
            $table->integer('supervisorId')->nullable();
            $table->enum('status', ['rejected', 'resigned', 'actual'])->default('actual');
            $table->foreignId('department_id')->constrained('departments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
