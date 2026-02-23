<?php

namespace App\Utils;


class SecurityUtils
{
    /**
     * Sanitizes the input string to prevent cross-site scripting (XSS) attacks.
     *
     * @param string $inputString The input string to be sanitized.
     * @return string The sanitized string.
     */
    public static function isInputXSSSafe($inputString): string
    {
        return htmlspecialchars($inputString, ENT_QUOTES, 'UTF-8');
    }
}
