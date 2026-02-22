<?php

namespace App\Http\Controllers;

use App\Services\QRCodeService;
use App\Services\ShortUrlService;
use App\Utils\SecurityUtils;
use Illuminate\Http\Request;

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

    public function redirectionShortIdToOriginalUrl(String $shortId)
    {
      return redirect($this->shortUrlService->getOriginalUrlByShortUrl(SecurityUtils::isInputXSSSafe($shortId)));
    }

    public function shorten(Request $request)
    {
        $request->validate([
            'url' => 'required|url|max:2048',
        ]);

        $cleanOriginalUrl = SecurityUtils::isInputXSSSafe($request->input('url'));

        $shortUrlObj = $this->shortUrlService->saveOrFindShortUrl($cleanOriginalUrl);

        $url = url("/url/" . $shortUrlObj->short_url);

        $qrCode = $this->qrCodeService->createQRCode($url);

        return redirect()->back()->with(['short_url' => $url, 'qr_code' => $qrCode]);
    }
}
