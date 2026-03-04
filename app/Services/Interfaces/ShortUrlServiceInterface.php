<?php

namespace App\Services\Interfaces;

use App\Models\ShortUrl;

interface ShortUrlServiceInterface
{
    public function saveOrFindShortUrl(string $url): ShortUrl;

    public function getOriginalUrlByShortUrl(string $short_id): ?string;


}
