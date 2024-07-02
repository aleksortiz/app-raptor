<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EntradaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'folio' => $this->faker->unique()->randomNumber(8),
            'cliente_id' => 1,
            'sucursal_id' => 1,
            'user_id' => 1,
            'origen' => 'ASEGURADORA',
            'aseguradora_id' => 6,
            'fabricante_id' => $this->faker->numberBetween(1, 10),
            'modelo' => $this->faker->word,
            'notas' => $this->faker->text,
            'serie' => $this->faker->word,
            'orden' => $this->faker->word,
            'area_trabajo' => '[]',
            'estatus' => 'PENDIENTE',
            'estatus_factura' => 'PENDIENTE',
            'servicio_interno' => false,
        ];
    }
}
