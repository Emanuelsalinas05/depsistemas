<?php

namespace Database\Factories;

use App\Models\Tarea;
use App\Models\User;
use App\Models\Worklog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Worklog>
 */
class WorklogFactory extends Factory
{
    protected $model = Worklog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tarea_id' => Tarea::factory(),
            'user_id' => User::factory(),
            'fecha' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'minutos' => $this->faker->numberBetween(15, 480), // 15 min a 8 horas
            'descripcion' => $this->faker->optional()->sentence(),
            'source' => $this->faker->randomElement(['manual', 'timer', 'import']),
            'created_by' => User::factory(),
        ];
    }
}
