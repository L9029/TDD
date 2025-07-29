<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase; // Se cambia a TestCase para el contexto de pruebas unitarias que necesita funciones propias de Laravel y no de PHPUnit

class UserTest extends TestCase
{
    /**
     * Test que determina si un usuario tiene muchos repositorios.
     */
    public function test_user_has_many_repositories(): void
    {
        // Crear una instancia de User
        $user = new User();

        // Verificar que la relación 'repositories' es una instancia de Collection
        $this->assertInstanceOf(Collection::class, $user->repositories);
    }
}
