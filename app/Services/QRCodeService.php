<?php

namespace App\Services;

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


    public function createQRCode(String $url)
    {
        return QrCode::format('svg')->size(200)->margin(2)
            ->errorCorrection('H')->generate($url);

    }

}
