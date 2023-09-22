<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('participatequestions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('UserId')->nullable();
            $table->foreign('UserId')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('questionId')->nullable();
            $table->foreign('questionId')->references('id')->on('questions')->onDelete('cascade');
            $table->unsignedBigInteger('optionId')->nullable();
            $table->foreign('optionId')->references('id')->on('options')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participatequestions');
    }
};
