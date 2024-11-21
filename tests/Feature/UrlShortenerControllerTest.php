<?php

namespace Tests\Feature;

use App\Models\Url;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UrlShortenerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_short_url()
    {
        // Creación de una URL acortada mediante el endpoint POST
        $response = $this->postJson('/api/url', [
            'url' => 'http://example.com',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'original_url' => 'http://example.com',
        ]);
    }

    public function test_get_all_urls()
    {
        // Preparamos un URL para probar
        Url::create([
            'original_url' => 'http://example.com',
            'short_code' => 'abc123'
        ]);

        // Petición para obtener todas las URLs acortadas
        $response = $this->getJson('/api/url');

        $response->assertStatus(200);
        $response->assertJsonFragment(['original_url' => 'http://example.com']);
    }

    public function test_redirect_to_original_url()
    {
        // Creamos un URL con su código corto
        $url = Url::create([
            'original_url' => 'http://example.com',
            'short_code' => 'abc123'
        ]);

        // Petición para redirigir
        $response = $this->getJson("/api/{$url->short_code}");

        $response->assertStatus(200);
        $response->assertJson(['url' => [
            'original_url' => 'http://example.com',
            'short_code' => 'abc123'
        ]]);
    }

    public function test_redirect_url_not_found()
    {
        // Petición con un short_code que no existe
        $response = $this->getJson("/api/nonexistent_code");

        $response->assertStatus(404);
        $response->assertJson(['error' => 'URL not found']);
    }

    public function test_delete_url()
    {
        // Crear una URL para eliminar
        $url = Url::create([
            'original_url' => 'http://example.com',
            'short_code' => 'abc123'
        ]);

        // Petición para eliminar la URL
        $response = $this->deleteJson("/api/url/{$url->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('url', ['id' => $url->id]);
    }

    public function test_delete_url_not_found()
    {
        // Intentar eliminar una URL que no existe
        $response = $this->deleteJson("/api/url/999");

        $response->assertStatus(404);
        $response->assertJson(['error' => 'URL not found']);
    }
}
