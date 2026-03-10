<?php

namespace App\Services;

use App\Exceptions\ShortUrlCreationException;
use App\Models\ShortUrl;
use App\Services\Interfaces\ShortUrlServiceInterface;
use Random\RandomException;

class ShortUrlService implements ShortUrlServiceInterface
{
    public function __construct()
    {
        //
    }

    /**
     * Generate a random short ID.
     *
     * @param int $numOfChars The number of characters to generate, defaults to 8.
     * @return string The generated short ID.
     * @throws RandomException
     */
private function generateShortId(int $numOfChars=8): string
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randomString = '';

    for ($i = 0; $i < $numOfChars; $i++) {
        $randomString .= $characters[random_int(0, strlen($characters) - 1)];
    }

    return $randomString;
}

    /**
     * Save or find short url in the database.
     *
     * @param string $url The original URL to be shortened.
     * @return ShortUrl  The short URL identifier object.
     * @throws RandomException
     * @throws ShortUrlCreationException
     */
    public function saveOrFindShortUrl(string $url): ShortUrl
{
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        throw new ShortUrlCreationException("Invalid URL provided");
    }

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

    /**
     * Save the original URL and its corresponding shortened URL to the database.
     *
     * @param string $originalUrl The original URL to be shortened.
     * @param string|null $short_id Optional custom short ID for the URL. If not provided, one will be generated.
     * @return ShortUrl The saved ShortUrl instance containing the original and shortened URLs.
     * @throws RandomException
     */
private function saveShortUrl(string $originalUrl, ?string $short_id = null): ShortUrl
{
        $shortUrl = new ShortUrl();
        $shortUrl->original_url = $originalUrl;
        $shortUrl->short_url = $short_id ?? $this->generateShortId();
        $shortUrl->save();

        return $shortUrl;
}

    /**
     * Retrieves the original URL associated with a given short URL ID.
     *
     * @param string $short_url The short URL identifier.
     * @return string|null The original URL if found, or null if not found.
     */
    public function getOriginalUrlByShortUrl(string $short_url): ?string
    {
        $shortUrl = ShortUrl::where('short_url', $short_url)->firstOrFail();


        return $shortUrl->original_url;
    }

    /**
     * Retrieves the short URL record associated with a given original URL.
     *
     * @param string $url The original URL.
     * @return ShortUrl|null The ShortUrl model instance if found, or null if not found.
     */
private function getShortUrlByOriginalUrlDao(string $url) : ?ShortUrl
{
    return ShortUrl::where('original_url', $url)->first();
}

    /**
     * Fetches the ShortUrl model instance associated with a given short URL ID.
     *
     * @param string $short_id The identifier for the short URL.
     * @return ShortUrl|null The ShortUrl model instance if found, or null if not found.
     */
private function getShortUrlByShortIdDao(string $short_id) : ?ShortUrl
{
    return ShortUrl::where('short_url', $short_id)->first();
}

}
