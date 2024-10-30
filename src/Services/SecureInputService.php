<?php

namespace App\Services;

class SecureInputService
{
    public function secureInput($input): string
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input, ENT_NOQUOTES, 'UTF-8');
        return htmlspecialchars($input);
    }
}