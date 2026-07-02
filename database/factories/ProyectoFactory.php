<?php

namespace Database\Factories;

use App\Models\Proyecto;
use App\Models\Sistema;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proyecto>
 */
class ProyectoFactory extends Factory
{
    protected $model = Proyecto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nombre = $this->faker->words(3, true) . ' Project';
        
        return [
            'sistema_id' => Sistema::factory(),
            'nombre' => $nombre,
            'slug' => \Str::slug($nombre),
            'objetivo' => $this->faker->sentence(),
            'fecha_inicio' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'fecha_fin' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
            'estatus' => $this->faker->randomElement(['planeado', 'en_progreso', 'en_pausa', 'cerrado']),
            'created_by' => User::factory(),
        ];
    }
}
