<?php

namespace Tests\Unit;

use App\Models\Url;
use App\Repositories\UrlRepository;
use App\Repositories\UrlRepositoryInterface;
use App\Services\UrlShortenerService;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UrlShortenerServiceTest extends TestCase
{
    use RefreshDatabase;
    private $urlRepositoryMock; // El mock creado con PHPUnit
    private $urlShortenerService;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear un mock para la interfaz del repositorio
        $this->urlRepositoryMock = $this->createMock(UrlRepository::class);

        // Inyectar el mock en el servicio
        $this->urlShortenerService = new UrlShortenerService($this->urlRepositoryMock);
    }

    public function test_create_short_url()
    {
        // Mock del repositorio
        $urlRepositoryMock = $this->createMock(UrlRepositoryInterface::class);

        // Mock del modelo URL
        $mockedUrl = new Url(['original_url' => 'http://example.com', 'short_code' => 'abc123']);

        // Expectativa del repositorio
        $urlRepositoryMock->expects($this->once())
            ->method('save')
            ->with('http://example.com', 'abc123')
            ->willReturn($mockedUrl);

        // Instancia del servicio con el repositorio mockeado
        $service = $this->getMockBuilder(UrlShortenerService::class)
            ->setConstructorArgs([$urlRepositoryMock])
            ->onlyMethods(['generateShortCode'])
            ->getMock();

        // Mockea el método generateShortCode para devolver un valor fijo
        $service->method('generateShortCode')
            ->willReturn('abc123');

        // Ejecuta el método a probar
        $result = $service->createShortUrl('http://example.com');

        // Validaciones
        $this->assertEquals('http://example.com', $result->original_url);
        $this->assertEquals('abc123', $result->short_code);
    }

    public function testGetOriginalUrl(): void
    {
        $shortCode = "abc123";
        $originalUrl = "http://example.com";

        // Simular el comportamiento del método "findByShortCode"
        $this->urlRepositoryMock
            ->method('findByShortCode')
            ->with($shortCode)
            ->willReturn(new Url([
                'original_url' => $originalUrl,
                'short_code' => $shortCode,
            ]));

        $result = $this->urlShortenerService->getOriginalUrl($shortCode);

        $this->assertInstanceOf(Url::class, $result);
        $this->assertEquals($originalUrl, $result->original_url);
    }
}
