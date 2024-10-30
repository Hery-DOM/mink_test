<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;

class Slug extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('slug', [$this,'slug']),
        ];
    }

    public function slug($value): array|string
    {

        $result = strtolower($value);
        $result = str_replace("é","e",$result);
        $result = str_replace("É","e",$result);
        $result = str_replace("è","e",$result);
        $result = str_replace("È","e",$result);
        $result = str_replace("ê","e",$result);
        $result = str_replace("Ê","e",$result);
        $result = str_replace("ë","e",$result);
        $result = str_replace("Ë","e",$result);
        $result = str_replace("à","a",$result);
        $result = str_replace("À","a",$result);
        $result = str_replace("ä","a",$result);
        $result = str_replace("Ä","a",$result);
        $result = str_replace("â","a",$result);
        $result = str_replace("Â","a",$result);
        $result = str_replace("ù","u",$result);
        $result = str_replace("Ù","u",$result);
        $result = str_replace("û","u",$result);
        $result = str_replace("Û","u",$result);
        $result = str_replace("î","i",$result);
        $result = str_replace("Î","i",$result);
        $result = str_replace("ï","i",$result);
        $result = str_replace("Ï","i",$result);
        $result = str_replace("ô","o",$result);
        $result = str_replace("Ô","o",$result);
        $result = str_replace(" ","-",$result);
        $result = str_replace("?","",$result);
        $result = str_replace("!","",$result);
        $result = str_replace(".","",$result);
        $result = str_replace(",","",$result);
        $result = str_replace("/","",$result);
        $result = str_replace("_","",$result);
        $result = str_replace(" : ","-",$result);
        return str_replace("'","-",$result);
    }

}
