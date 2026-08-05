<?php

namespace App\Support;

use Illuminate\Support\Str;

class Url
{
    /** People type "growsphere.ng"; the url validator wants a scheme. */
    public static function normalize(?string $url): ?string
    {
        $url = trim((string) $url);

        if ($url === '') {
            return null;
        }

        return Str::startsWith($url, ['http://', 'https://']) ? $url : 'https://'.$url;
    }

    /** A short, readable label for a link button. */
    public static function host(?string $url): ?string
    {
        $host = parse_url((string) $url, PHP_URL_HOST);

        return $host ? Str::of($host)->after('www.')->toString() : null;
    }
}
