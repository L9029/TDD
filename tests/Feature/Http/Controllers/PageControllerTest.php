<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Repository;

class PageControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que valida la pagina de inicio.
     */
    public function test_home(): void
    {
        $this->withExceptionHandling();

        $repository = Repository::factory()->create();

        $this->get('/')
            ->assertStatus(200)
            ->assertSee($repository->url);
    }
}
