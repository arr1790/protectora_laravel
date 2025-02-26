<?php

namespace Database\Factories;


use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DonationFactory extends Factory
{
   
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),  // Nombre de la persona que hace la donación
            'amount' => $this->faker->randomNumber(2),  // Monto aleatorio entre 10 y 1000
            'user_id' => User::factory(),  // Crear un usuario aleatorio y asociarlo con la donación
            'date_donation' => now(),  // Fecha actual para la donación
        ];
    }
}
