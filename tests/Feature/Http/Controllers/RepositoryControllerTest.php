<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RepositoryControllerTest extends TestCase
{
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
}
