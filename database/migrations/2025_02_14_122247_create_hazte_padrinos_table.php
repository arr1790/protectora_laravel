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
        Schema::create('hazte_padrinos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('address');
            $table->string('dni');
            $table->string('city');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('animal_id')->constrained()->onDelete('cascade'); 
            $table->string('phone');
            $table->string('email');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hazte_padrinos');
    }
};
