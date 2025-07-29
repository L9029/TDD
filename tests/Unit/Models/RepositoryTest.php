<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que valida que el modelo Repository pertenece a un usuario.
     *
     * @return void
     */
    public function test_repository_belongs_to_user(): void
    {
        // Creamos un repositorio usando el factory
        $repository = Repository::factory()->create();

        // Verificamos que el repositorio tiene un usuario asociado
        $this->assertInstanceOf(User::class, $repository->user);
    }
}
