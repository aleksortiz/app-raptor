<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proveedor>
 */
class PersonalFactory extends Factory
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
            'sueldo' => $this->faker->randomFloat(2, 1000, 10000),
            'telefono' => $this->faker->phoneNumber(),
            'domicilio' => $this->faker->address(),
            'contacto_emergencia' => $this->faker->name(),
            'notas' => $this->faker->text(),
            'activo' => true,
            'destajo' => $this->faker->boolean(),
        ];
    }
}
