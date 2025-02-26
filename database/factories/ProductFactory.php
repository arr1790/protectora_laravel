<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Lista de URLs de imágenes predefinidas en Cloudinary
        $imageUrls = [
            'https://res.cloudinary.com/arr17/image/upload/v1739902609/Taza-Emociones_ii3g0z.jpg',
            'https://res.cloudinary.com/arr17/image/upload/v1739902598/Botella-aluminio-tu-dejas-huella-820x820_ylkkbc.jpg',
            'https://res.cloudinary.com/arr17/image/upload/v1739902587/Bolsa-plegable-perrito1-820x820_vlrisg.jpg',
            'https://res.cloudinary.com/arr17/image/upload/v1739902491/61j2EV-e54L_i68wb9.jpg',
            'https://res.cloudinary.com/arr17/image/upload/v1739902447/61RQbxdgmOL_jtvyzr.jpg'
        ];

        // Selecciona una imagen aleatoria de la lista
        $randomImage = $imageUrls[array_rand($imageUrls)];

        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomNumber(2),
            'description' => $this->faker->text(),
            'image' => $randomImage, 
            'user_id' => User::factory(),
        ];
    }
}