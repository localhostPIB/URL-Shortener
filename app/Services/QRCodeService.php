<?php

namespace App\Services;

use App\Exceptions\QRCodeCreationException;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeService
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
     * @throws QRCodeCreationException
     */
    public function createQRCode(string $url)
    {
        try {
            return QrCode::format('svg')->size(200)->margin(2)
                ->errorCorrection('H')->generate($url);
        } catch (QRCodeCreationException $e) {
            throw new QRCodeCreationException();
        }
    }

}
