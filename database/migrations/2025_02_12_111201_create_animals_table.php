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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('race')->nullable(); 
            $table->unsignedInteger('age'); 
            $table->string('sex')->default('Masculino'); // Valor predeterminado para el campo 'sex'
            $table->string('size')->default('Pequeño'); // Valor predeterminado para el campo 'size'
            $table->enum('status', ['disponible', 'adoptando', 'pendiente'])->default('disponible'); 
            $table->string('image')->nullable(); 
            $table->text('description'); 
        
            $table->timestamps();
        });
        

        
    }
            
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
