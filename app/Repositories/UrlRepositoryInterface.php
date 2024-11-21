<?php
namespace App\Repositories;
use App\Models\Url;

interface UrlRepositoryInterface {
    public function save(string $originalUrl, string $shortCode): Url;
    public function findByShortCode(string $shortCode): ?Url;
    public function exists(string $shortCode): bool;

}
