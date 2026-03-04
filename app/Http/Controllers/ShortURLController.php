<?php

namespace App\Http\Controllers;

use App\Exceptions\ShortUrlCreationException;
use App\Services\Interfaces\QRCodeServiceInterface;
use App\Services\Interfaces\ShortUrlServiceInterface;
use App\Services\QRCodeService;
use App\Services\ShortUrlService;
use App\Utils\SecurityUtils;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Random\RandomException;

class ShortURLController extends Controller
{

    private ShortUrlServiceInterface $shortUrlServiceInterface;

    private QRCodeServiceInterface $qrCodeServiceInterface;

    public function __construct(ShortUrlService $shortUrlService, QRCodeService $qrCodeService)
    {
        $this->shortUrlServiceInterface = $shortUrlService;
        $this->qrCodeServiceInterface = $qrCodeService;
    }

    public function index()
    {
        return view('ShortURL.index');
    }

    /**
     * The redirection to get the original URL from a shortened URL.
     *
     * @param string $shortId
     * @return RedirectResponse|Redirector
     */
    public function redirectionShortIdToOriginalUrl(string $shortId)
    {
      return redirect($this->shortUrlServiceInterface->getOriginalUrlByShortUrl(SecurityUtils::e($shortId)));
    }

    /**
     * Creates a shortened URL from a valid URL.
     *
     * @throws ShortUrlCreationException|RandomException
     */
    public function shorten(Request $request)
    {
        $request->validate([
            'url' => 'required|url|max:2048',
        ]);

        $cleanOriginalUrl = SecurityUtils::e($request->input('url'));

        $shortUrlObj = $this->shortUrlServiceInterface->saveOrFindShortUrl($cleanOriginalUrl);

        $url = url("/url/" . $shortUrlObj->short_url);

        $qrCode = $this->qrCodeServiceInterface->createQRCode($url);

        return redirect()->back()->with(['short_url' => $url, 'qr_code' => $qrCode]);
    }
}
