<?php

namespace App\Http\Controllers;

use App\Exceptions\QRCodeCreationException;
use App\Exceptions\ShortUrlCreationException;
use App\Services\QRCodeService;
use App\Services\ShortUrlService;
use App\Utils\SecurityUtils;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ShortURLController extends Controller
{

    private ShortUrlService $shortUrlService;

    private QrCodeService $qrCodeService;

    public function __construct(ShortUrlService $shortUrlService, QrCodeService $qrCodeService)
    {
        $this->shortUrlService = $shortUrlService;
        $this->qrCodeService = $qrCodeService;
    }

    public function index()
    {
        return view('ShortURL.index');
    }

    /**
     * The redirection to obtain the original URL from a shortened URL.
     *
     * @param string $shortId
     * @return RedirectResponse|Redirector
     */
    public function redirectionShortIdToOriginalUrl(string $shortId)
    {
      return redirect($this->shortUrlService->getOriginalUrlByShortUrl(SecurityUtils::e($shortId)));
    }

    /**
     * Creates a shortened URL from a valid URL.
     *
     * @throws ShortUrlCreationException| QRCodeCreationException
     */
    public function shorten(Request $request)
    {
        $request->validate([
            'url' => 'required|url|max:2048',
        ]);

        $cleanOriginalUrl = SecurityUtils::e($request->input('url'));

        $shortUrlObj = $this->shortUrlService->saveOrFindShortUrl($cleanOriginalUrl);

        $url = url("/url/" . $shortUrlObj->short_url);

        $qrCode = $this->qrCodeService->createQRCode($url);

        return redirect()->back()->with(['short_url' => $url, 'qr_code' => $qrCode]);
    }
}
