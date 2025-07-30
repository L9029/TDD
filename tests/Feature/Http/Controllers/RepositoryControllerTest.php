<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class RepositoryControllerTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    /**
     * Test de middleware para cuando un usuario no autenticado intenta acceder a las rutas de repositorios.
     *
     * @return void
     */
    public function test_guest(): void
    {
        // Verifica que las rutas de repositorios redirijan a la página de inicio de sesión
        $this->get('/repositories')->assertRedirect('/login'); // Ruta index
        $this->get('/repositories/create')->assertRedirect('/login'); // Ruta create
        $this->post('/repositories', [])->assertRedirect('/login'); // Ruta store
        $this->get('/repositories/1')->assertRedirect('/login'); // Ruta show
        $this->get('/repositories/1/edit')->assertRedirect('/login'); // Ruta edit
        $this->put('/repositories/1')->assertRedirect('/login'); // Ruta update
        $this->delete('/repositories/1')->assertRedirect('/login'); // Ruta destroy
    }

    /**
     * Test que valida que un usuario autenticado pueda crear un repositorio.
     *
     * @return void
     */
    public function test_post(): void {

        $this->withoutMiddleware(); // Desactiva middleware para pruebas

        // Información de ejemplo para crear un repositorio
        $data = [
            "url" => $this->faker->url(),
            "description" => $this->faker->text(),
        ];

        // Se crea un usuario autenticado
        $user = User::factory()->create();

        // Se simula la autenticación del usuario y se envía una solicitud POST para crear un repositorio
        $this->actingAs($user)
            ->post('/repositories', $data)
            ->assertRedirect('/repositories');

        // Verifica que el repositorio se haya creado en la base de datos
        $this->assertDatabaseHas('repositories', $data);
    }
}
