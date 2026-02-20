<?php

namespace App\Utils;


class SecurityUtils
{
    public static function isInputXSSSafe($inputString): string
    {
        return htmlspecialchars($inputString, ENT_QUOTES, 'UTF-8');
    }
}
