<?php

namespace App\Http\Controllers;

use App\Services\ShortUrlService;
use App\Utils\SecurityUtils;
use Illuminate\Http\Request;

class ShortURLController extends Controller
{

    private ShortUrlService $shortUrlService;

    public function __construct(ShortUrlService $shortUrlService)
    {
        $this->shortUrlService = $shortUrlService;
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

        return redirect()->back()->with('short_url', url("/url/" . $shortUrlObj->short_url));
    }
}
