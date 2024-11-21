<?php
namespace App\Repositories;
use App\Models\Url;

class UrlRepository implements UrlRepositoryInterface
{
    public function save(string $originalUrl, string $shortCode): Url
    {
        return Url::create([
            'original_url' => $originalUrl,
            'short_code' => $shortCode,
        ]);
    }

    public function findByShortCode(string $shortCode): ?Url
    {
        return Url::where('short_code', $shortCode)->first();
    }

    public function exists(string $shortCode): bool
    {
        return Url::where('short_code', $shortCode)->exists();
    }
}
