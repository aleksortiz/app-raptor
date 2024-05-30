<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proveedor>
 */
class ProveedorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
            'rfc' => $this->faker->name(),
            'razon_social' => $this->faker->name(),
            'calle' => $this->faker->streetName,
            'numero' => $this->faker->buildingNumber,
            'colonia' => $this->faker->sentence(3),
            'codigo_postal' => $this->faker->postcode,
            'ciudad' => $this->faker->city,
            'estado' => $this->faker->state,
            'telefono' => $this->faker->phoneNumber,
            'correo' => $this->faker->email,
        ];
    }
}
