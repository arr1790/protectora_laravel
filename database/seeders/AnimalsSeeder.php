<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnimalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('animals')->insert([
            'name' => 'Coqui',
            'race' => 'Pastor Alemán',
            'age' => 3,
            'sex' => 'Masculino', 
            'size' => 'Grande',
            'status' => 'disponible',
            'image' => 'https://res.cloudinary.com/arr17/image/upload/v1740159266/cachorro-pastor-aleman-8_qoci3z.jpg', // URL de imagen
            'description' => '
Es un amigo muy cariñoso y juguetón, y necesita de mucho cariño, de una persona que esté atenta a él.',
        ]);

        DB::table('animals')->insert([
            'name' => 'Canijo',
            'race' => 'Bulldog Ingles',
            'age' => 2,
            'sex' => 'Masculino', 
            'size' => 'Pequeña',
            'status' => 'disponible',
            'image' => 'https://res.cloudinary.com/arr17/image/upload/v1739528559/perro-bulldog-ingles_cavg7d.jpg', // URL de imagen
            'description' => '
Es un perro asustadizo, le cuesta relacionarse, pero en nada que tenga cariño, es un animal encantador.',
        ]);

        DB::table('animals')->insert([
            'name' => 'Simba',
            'race' => 'Labrador retriever',
            'age' => 1,
            'sex' => 'Masculino',  
            'size' => 'Grande',
            'status' => 'disponible',
            'image' => 'https://res.cloudinary.com/arr17/image/upload/c_fill,w_800,h_500,g_face/v1739528647/labrador-retriever-dog-breed-info_rdsnnb.jpg', // URL de imagen
            'description' => '
Es un perro muy cariñoso, le encanta jugar, ser amado, ya que en su pasado no lo tuvo.',
        ]);
    }
}
