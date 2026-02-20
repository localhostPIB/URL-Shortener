<?php

namespace Tests\Unit;

use App\Models\ShortUrl;
use App\Services\ShortUrlService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class URLTest extends TestCase
{
    use RefreshDatabase;

    private ShortUrlService $shortUrlService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->shortUrlService = app(ShortUrlService::class);
    }

    /** @test */
    public function itCreatesAShortUrlWithGeneratedCode()
    {
        $originalUrl = 'https://example.com/long-url';
        $shortUrl = $this->shortUrlService->saveOrFindShortUrl($originalUrl);

        $this->assertInstanceOf(ShortUrl::class, $shortUrl);
        $this->assertEquals($originalUrl, $shortUrl->original_url);
        $this->assertNotEmpty($shortUrl->short_url);
        $this->assertEquals(8, strlen($shortUrl->short_url));

    }

}
