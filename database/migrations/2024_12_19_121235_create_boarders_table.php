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
        Schema::create('boarders', function (Blueprint $table) {
            $table->id();
            $table->date('check_in');
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->string('name');
            $table->integer('age');
            $table->string('gender');
            $table->string('course')->nullable();
            $table->text('address');
            $table->string('phone');
            $table->string('contact_person');
            $table->string('contact_person_phone');
            $table->string('relation');
            $table->boolean('staus')->default(1)->nullable();
            $table->decimal('balance', 10, 2)->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boarders');
    }
};
