<?php

namespace App\Services;

use App\Services\Interfaces\QRCodeServiceInterface;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeService implements QRCodeServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    /**
     * Create a QR code (in SVG format) from a given URL.
     *
     */
    public function createQRCode(string $url)
    {
        return QrCode::format('svg')->size(200)->margin(2)
            ->errorCorrection('H')->generate($url);
    }

}
