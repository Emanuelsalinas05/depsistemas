<?php

namespace Database\Factories;

use App\Models\Acuerdo;
use App\Models\Proyecto;
use App\Models\Reunion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Acuerdo>
 */
class AcuerdoFactory extends Factory
{
    protected $model = Acuerdo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reunion_id' => $this->faker->optional()->randomElement([Reunion::factory(), null]),
            'proyecto_id' => $this->faker->optional()->randomElement([Proyecto::factory(), null]),
            'titulo' => $this->faker->sentence(),
            'detalle' => $this->faker->optional()->paragraph(),
            'responsable_id' => $this->faker->optional()->randomElement([User::factory(), null]),
            'fecha_compromiso' => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
            'estatus' => $this->faker->randomElement(['pendiente', 'en_progreso', 'cumplido', 'cancelado']),
        ];
    }
}
