<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('todos', function (Blueprint $table) {
        $table->id();
        $table->longText('name');
        $table->longText('task')->nullable();
        $table->boolean('is_incomplete')->default(1); // Set default value to 1 (true) for incomplete tasks
        $table->boolean('is_completed')->default(0); // Set default value to 0 (false) for completed tasks
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
