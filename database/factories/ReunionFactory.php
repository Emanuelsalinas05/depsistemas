<?php

namespace Database\Factories;

use App\Models\Proyecto;
use App\Models\Reunion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reunion>
 */
class ReunionFactory extends Factory
{
    protected $model = Reunion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fechaInicio = $this->faker->dateTimeBetween('-1 month', '+1 month');
        
        return [
            'proyecto_id' => $this->faker->optional()->randomElement([Proyecto::factory(), null]),
            'titulo' => $this->faker->sentence(),
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $this->faker->optional()->dateTimeBetween($fechaInicio, '+2 hours'),
            'ubicacion' => $this->faker->optional()->randomElement([$this->faker->address(), 'Zoom', 'Teams', null]),
            'descripcion' => $this->faker->optional()->paragraph(),
            'created_by' => User::factory(),
        ];
    }
}
