<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

/**
 * Crea (una sola vez) el usuario administrador inicial a partir de variables de entorno.
 *
 * Uso en producción institucional:
 * - Definir INITIAL_ADMIN_EMAIL e INITIAL_ADMIN_PASSWORD solo en el primer despliegue o en un pipeline controlado.
 * - Eliminar INITIAL_ADMIN_PASSWORD del entorno después de ejecutar el seeder o de verificar el acceso.
 * - No versionar valores reales en .env bajo control de código.
 */
class InitialAdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = trim((string) env('INITIAL_ADMIN_EMAIL', ''));
        $plain = env('INITIAL_ADMIN_PASSWORD');

        if ($email === '' || $plain === null || $plain === '') {
            if ($this->command) {
                $this->command->warn('InitialAdminSeeder: INITIAL_ADMIN_EMAIL / INITIAL_ADMIN_PASSWORD no definidos. No se creó ni actualizó usuario inicial.');
            }

            return;
        }

        $passwordRule = app()->environment('production')
            ? Password::min(12)->mixedCase()->numbers()->symbols()
            : Password::min(8);

        $validator = Validator::make(
            ['email' => $email, 'password' => $plain],
            [
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', $passwordRule],
            ]
        );

        if ($validator->fails()) {
            throw new \InvalidArgumentException(
                'InitialAdminSeeder: datos inválidos: '.$validator->errors()->toJson()
            );
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => (string) env('INITIAL_ADMIN_NAME', 'Administrador del sistema'),
                'password' => $plain,
                'email_verified_at' => now(),
            ]
        );

        if (filter_var(env('INITIAL_ADMIN_UPDATE_PASSWORD', false), FILTER_VALIDATE_BOOLEAN)) {
            $user->forceFill(['password' => $plain])->save();
        }

        if (! $user->hasRole('superadmin')) {
            $user->assignRole('superadmin');
        }

        if ($this->command) {
            $this->command->info('InitialAdminSeeder: usuario inicial configurado con rol superadmin.');
            $this->command->warn('Elimine INITIAL_ADMIN_PASSWORD del entorno cuando ya no sea necesario.');
        }
    }
}
