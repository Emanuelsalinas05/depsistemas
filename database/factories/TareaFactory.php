<?php

namespace Database\Factories;

use App\Models\Proyecto;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tarea>
 */
class TareaFactory extends Factory
{
    protected $model = Tarea::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'proyecto_id' => Proyecto::factory(),
            'titulo' => $this->faker->sentence(),
            'descripcion' => $this->faker->optional()->paragraph(),
            'tipo' => $this->faker->randomElement(['feature', 'bug', 'soporte', 'mejora', 'doc']),
            'prioridad' => $this->faker->randomElement(['alta', 'media', 'baja']),
            'estado' => $this->faker->randomElement(['nuevo', 'en_curso', 'en_revision', 'listo_release', 'cerrado']),
            'asignado_a' => User::factory(),
            'fecha_inicio' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'fecha_fin' => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
            'estimacion_horas' => $this->faker->optional()->randomFloat(2, 1, 40),
            'progreso' => $this->faker->numberBetween(0, 100),
            'evidencia_url' => $this->faker->optional()->url(),
            'created_by' => User::factory(),
        ];
    }
}
