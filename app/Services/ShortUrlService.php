<?php

namespace App\Services;

use App\Models\ShortUrl;

class ShortUrlService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

public function generateShortId(int $numOfChars=8): string
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randomString = '';
    for ($i = 0; $i < $numOfChars; $i++) {
        $randomString .= $characters[random_int(0, strlen($characters) - 1)];
    }

    return $randomString;
}

public function saveOrFindShortUrl(string $url): ShortUrl
{
    $short_url = $this->getShortUrlByOriginalUrlDao($url);

    if ($short_url !== null) {
        return $short_url;
    }

    $short_id = $this->generateShortId();

    if ($this->getShortUrlByShortIdDao($short_id)){
        return $this->saveOrFindShortUrl($url);
    }

    return $this->saveShortUrl($url, $short_id);
}

private function saveShortUrl(string $originalUrl, ?string $short_id = null): ShortUrl
{
        $shortUrl = new ShortUrl();
        $shortUrl->original_url = $originalUrl;
        $shortUrl->short_url = $short_id ?? $this->generateShortId();
        $shortUrl->save();

        return $shortUrl;
}

public function getOriginalUrlByShortUrl(string $short_id): ?string
{
    return ShortUrl::where('short_url', $short_id)->value('original_url');
}

private function getShortUrlByOriginalUrlDao(string $url) : ?ShortUrl
{
    return ShortUrl::where('original_url', $url)->first();
}

private function getShortUrlByShortIdDao(string $short_id) : ?ShortUrl
{
    return ShortUrl::where('short_url', $short_id)->first();
}

}
