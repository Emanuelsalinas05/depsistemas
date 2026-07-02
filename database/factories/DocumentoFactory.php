<?php

namespace Database\Factories;

use App\Models\Documento;
use App\Models\Release;
use App\Models\Sistema;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Documento>
 */
class DocumentoFactory extends Factory
{
    protected $model = Documento::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sistema_id' => Sistema::factory(),
            'release_id' => $this->faker->optional()->randomElement([Release::factory(), null]),
            'tipo' => $this->faker->randomElement(['manual_tecnico', 'manual_usuario', 'runbook', 'adr', 'postmortem']),
            'titulo' => $this->faker->sentence(),
            'estado' => $this->faker->randomElement(['borrador', 'publicado', 'archivado']),
            'created_by' => User::factory(),
        ];
    }
}
