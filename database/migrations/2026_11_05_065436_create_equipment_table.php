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
       Schema::create('equipment', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name', 50);
    $table->text('description');
    $table->decimal('dailyPrice', 10, 2);
    $table->unsignedInteger('categoryId');

    $table->foreign('categoryId')
          ->references('id')
          ->on('categories');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
