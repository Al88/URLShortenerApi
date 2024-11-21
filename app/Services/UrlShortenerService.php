<?php
namespace App\Services;
use App\Models\Url;
use App\Repositories\UrlRepository;
use App\Repositories\UrlRepositoryInterface;

class UrlShortenerService
{
    private $urlRepository;

    public function __construct(UrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    public function generateShortCode(string $url): string
    {
        do {
            $shortCode = substr(md5($url . time() . uniqid()), 0, 8);
        } while ($this->urlRepository->exists($shortCode));

        return $shortCode;
    }

    public function createShortUrl(string $originalUrl): Url
    {
        $shortCode = $this->generateShortCode($originalUrl);
        return $this->urlRepository->save($originalUrl, $shortCode);
    }

    public function getOriginalUrl(string $shortCode): ?Url
    {
        return $this->urlRepository->findByShortCode($shortCode);
    }
}

