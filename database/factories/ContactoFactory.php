<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->name,
            'correo' => $this->faker->unique->safeEmail,
            'departamento' => $this->faker->randomElement([
                'SISTEMAS',
                'COMPRAS',
                'GERENCIA',
                'PRODUCCION',
                'MANTENIMIENTO',
            ]),
            'prefijo' => $this->faker->randomElement([
                'ING.',
                'ARQ.',
                'LIC.',
                'SR.',
                'SRA.',
            ]),
            'model_type' => $this->faker->randomElement([Cliente::class, Proveedor::class]),
            'model_id' => $this->faker->numberBetween(1, 200),
        ];
    }
}
