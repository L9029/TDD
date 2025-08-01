<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Repository;
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
     * Test que valida que un usuario autenticado pueda ver la lista de repositorios asociados a él.
     *
     * @return void
     */
    public function test_index_with_data(): void
    {
        $this->withoutMiddleware(); // Desactiva middleware para pruebas

        // Crea un usuario autenticado
        $user = User::factory()->create();

        // Crea repositorios asociados al usuario
        $repository = Repository::factory()->count(3)->create(['user_id' => $user->id]);

        // Verifica que la vista de repositorios muestre los repositorios del usuario autenticado
        $this->actingAs($user)
            ->get('/repositories')
            ->assertStatus(200)
            ->assertSee($repository[0]->id)
            ->assertSee($repository[0]->url);
    }

    /**
     * Test que valida que un usuario autenticado no pueda ver la lista de repositorios que no esten asociados a él.
     * 
     * @return void
     */
    public function test_index_empty(): void
    {
        $this->withoutMiddleware(); // Desactiva middleware para pruebas

        $user = User::factory()->create(); // Crea un usuario autenticado
        $repository = Repository::factory()->create(); // Crea un repositorio que no pertenece al usuario

        // Verifica que la vista de repositorios esté vacía cuando no hay repositorios
        $this->actingAs($user)
            ->get('/repositories')
            ->assertStatus(200)
            ->assertSee('No hay repositorios disponibles.');
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

    /**
     * Test que valida que un usuario autenticado no pueda crear un repositorio sin los campos requeridos.
     *
     * @return void
     */
    public function test_validate_store(): void
    {
        $this->withoutMiddleware(); // Desactiva middleware para pruebas

        // Se crea un usuario autenticado
        $user = User::factory()->create();

        // Se simula la autenticación del usuario y se envía una solicitud POST sin los campos requeridos
        $this->actingAs($user)
            ->post('/repositories', [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['url', 'description']);
    }

    /**
     * Test que valida que un usuario autenticado pueda actualizar un repositorio existente.
     * 
     * @return void
     */
    public function test_update(): void
    {
        $this->withoutMiddleware(); // Desactiva middleware para pruebas

        // Información de ejemplo para actualizar un repositorio
        $data = [
            "url" => $this->faker->url(),
            "description" => $this->faker->text(),
        ];

        // Se crea un usuario autenticado y un repositorio asociado
        $user = User::factory()->create();
        $repository = Repository::factory()->create([
            'user_id' => $user->id, // Asegura que el repositorio pertenezca al usuario
        ]);

        // Se simula la autenticación del usuario y se envía una solicitud PUT para actualizar el repositorio
        $this->actingAs($user)
            ->put("/repositories/{$repository->id}", $data)
            ->assertRedirect("/repositories/{$repository->id}/edit");

        // Verifica que el repositorio se haya actualizado en la base de datos
        $this->assertDatabaseHas('repositories', $data);
    }

    /**
     * Test que valida que un usuario autenticado no pueda actualizar un repositorio sin los campos requeridos.
     *
     * @return void
     */
    public function test_validate_update(): void
    {
        $this->withoutMiddleware(); // Desactiva middleware para pruebas

        // Se crea un usuario autenticado y un repositorio asociado
        $user = User::factory()->create();
        $repository = Repository::factory()->create();

        // Se simula la autenticación del usuario y se envía una solicitud PUT sin los campos requeridos
        $this->actingAs($user)
            ->put("/repositories/{$repository->id}", [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['url', 'description']);
    }

    /**
     * Test que valida que un usuario autenticado no pueda actualizar un repositorio que no le pertenece.
     * 
     * @return void
     */
    public function test_update_policy(): void
    {
        $this->withoutMiddleware(); // Desactiva middleware para pruebas

        // Se crea un usuario autenticado y un repositorio asociado
        $user = User::factory()->create(); // Usuario con id 1
        $repository = Repository::factory()->create(); // Repositorio que tiene un id diferente al del usuario con id 1

        // Información de ejemplo para actualizar un repositorio
        $data = [
            "url" => $this->faker->url(),
            "description" => $this->faker->text(),
        ];

        // Se simula la autenticación del usuario y se envía una solicitud PUT para actualizar el repositorio
        $this->actingAs($user)
            ->put("/repositories/{$repository->id}", $data)
            ->assertStatus(403); // Verifica que se deniegue el acceso
    }

    /**
     * Test que valida que un usuario autenticado pueda eliminar un repositorio existente.
     *
     * @return void
     */
    public function test_destroy(): void
    {
        $this->withoutMiddleware(); // Desactiva middleware para pruebas

        // Se crea un usuario autenticado y un repositorio asociado
        $user = User::factory()->create();
        $repository = Repository::factory()->create([
            'user_id' => $user->id, // Asegura que el repositorio pertenezca al usuario
        ]);

        // Se simula la autenticación del usuario y se envía una solicitud DELETE para eliminar el repositorio
        $this->actingAs($user)
            ->delete("/repositories/{$repository->id}")
            ->assertRedirect('/repositories');

        // Verifica que el repositorio ya no exista en la base de datos
        $this->assertDatabaseMissing('repositories', $repository->toArray());
    }

    /**
     * Test que valida que un usuario autenticado no pueda eliminar un repositorio que no le pertenece.
     *
     * @return void
     */
    public function test_destroy_policy(): void
    {
        $this->withoutMiddleware(); // Desactiva middleware para pruebas

        // Se crea un usuario autenticado y un repositorio asociado
        $user = User::factory()->create(); // Usuario con id 1
        $repository = Repository::factory()->create(); // Repositorio que tiene un id diferente al del usuario con id 1

        // Se simula la autenticación del usuario y se envía una solicitud DELETE para eliminar el repositorio
        $this->actingAs($user)
            ->delete("/repositories/{$repository->id}")
            ->assertStatus(403); // Verifica que se deniegue el acceso
    }
}
