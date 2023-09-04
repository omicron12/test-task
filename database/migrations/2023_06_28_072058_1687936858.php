<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('article')->nullable();
            $table->string('barcode')->nullable();
            $table->string('category')->nullable();
            $table->string('brand')->nullable();
            $table->string('subject')->nullable();
            $table->string('source');
            $table->string('hash')->unique();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
