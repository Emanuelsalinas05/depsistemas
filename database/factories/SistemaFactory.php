<?php

namespace Database\Factories;

use App\Models\Sistema;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sistema>
 */
class SistemaFactory extends Factory
{
    protected $model = Sistema::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nombre = $this->faker->company() . ' System';
        
        return [
            'nombre' => $nombre,
            'slug' => \Str::slug($nombre),
            'descripcion' => $this->faker->paragraph(),
            'area_usuaria' => $this->faker->randomElement(['RRHH', 'Finanzas', 'Ventas', 'Operaciones', 'TI']),
            'dueno_funcional' => $this->faker->name(),
            'criticidad' => $this->faker->randomElement(['alta', 'media', 'baja']),
            'estatus' => $this->faker->randomElement(['activo', 'mantenimiento', 'legado', 'deprecado']),
            'url_prod' => $this->faker->optional()->url(),
            'url_qa' => $this->faker->optional()->url(),
            'url_dev' => $this->faker->optional()->url(),
            'repositorio_url' => $this->faker->optional()->url(),
            'created_by' => User::factory(),
        ];
    }
}
