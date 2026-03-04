<?php

namespace Tests\Unit;


use App\Exceptions\ShortUrlCreationException;
use App\Models\ShortUrl;
use App\Services\Interfaces\ShortUrlServiceInterface;
use App\Services\ShortUrlService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Random\RandomException;
use Tests\TestCase;
use function Symfony\Component\String\s;


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


    /** @test
     * @throws ShortUrlCreationException|RandomException
     */
    public function itCreatesAShortUrlWithGeneratedCode()
    {
        $originalUrl = 'https://example.com/long-url';
        $shortUrl = $this->shortUrlServiceInterface->saveOrFindShortUrl($originalUrl);

        $this->assertInstanceOf(ShortUrl::class, $shortUrl);
        $this->assertEquals($originalUrl, $shortUrl->original_url);
        $this->assertNotEmpty($shortUrl->short_url);
        $this->assertEquals(8, strlen($shortUrl->short_url));

    }

    /** @test */
    public function isShortUrlUnique()
    {
        $shortUrl1 = $this->shortUrlServiceInterface->saveOrFindShortUrl('https://www.google.com');
        $shortUrl2 = $this->shortUrlServiceInterface->saveOrFindShortUrl('https://www.google.com');

        $this->assertNotEquals($shortUrl1, $shortUrl2);
    }

}
