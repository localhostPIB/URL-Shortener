<?php

namespace Tests\Unit;

use App\Exceptions\ShortUrlCreationException;
use App\Models\ShortUrl;
use App\Services\Interfaces\ShortUrlServiceInterface;
use App\Services\ShortUrlService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Random\RandomException;
use Tests\TestCase;


class URLTest extends TestCase
{
    use RefreshDatabase;

    private ShortUrlServiceInterface $shortUrlServiceInterface;

    protected function setUp(): void
    {
        parent::setUp();
        $this->shortUrlServiceInterface= app(ShortUrlService::class);
    }

    public function testInvalidUrlRedirectsBackWithError()
    {
        $response = $this->from('/form')
            ->post('/shorten', [
                'url' => 'invalid-url'
            ]);

        $response
            ->assertRedirect('/form')
            ->assertSessionHasErrors();
    }


    /**
     * @throws ShortUrlCreationException|RandomException
     */
    public function testItCreatesAShortUrlWithGeneratedCode()
    {
        $originalUrl = 'https://example.com/long-url';
        $shortUrl = $this->shortUrlServiceInterface->saveOrFindShortUrl($originalUrl);

        $this->assertInstanceOf(ShortUrl::class, $shortUrl);
        $this->assertEquals($originalUrl, $shortUrl->original_url);
        $this->assertNotEmpty($shortUrl->short_url);
        $this->assertEquals(8, strlen($shortUrl->short_url));

    }

    /**
     * Test that the method returns a unique short URL.
     */
    public function testIsShortUrlUnique()
    {
        $shortUrl1 = $this->shortUrlServiceInterface->saveOrFindShortUrl('https://www.google.com');
        $shortUrl2 = $this->shortUrlServiceInterface->saveOrFindShortUrl('https://www.google.com');

        $this->assertNotEquals($shortUrl1, $shortUrl2);
    }


    /**
     * Test that the method throws a ModelNotFoundException when an invalid short URL is provided.
     */
    public function testURLNotFound()
    {
        $this->expectException(ModelNotFoundException::class);

        $this->shortUrlServiceInterface->getOriginalUrlByShortUrl("xxxx");
    }

    /**
     * Test that the original URL is correctly retrieved using the short URL.
     */
    public function testURLFound()
    {
        $shortUrl = $this->shortUrlServiceInterface->saveOrFindShortUrl('https://www.google.com');
        $originalUrl = $this->shortUrlServiceInterface->getOriginalUrlByShortUrl($shortUrl->short_url);

        $this->assertEquals('https://www.google.com', $originalUrl);
    }

}
