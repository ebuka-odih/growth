<?php

namespace App\Support;

/**
 * Turns the URLs people paste out of YouTube or Vimeo into something that can
 * be embedded, plus the poster frame used for the click-to-play preview.
 */
class Video
{
    public static function isSupported(?string $url): bool
    {
        return static::youtubeId($url) !== null || static::vimeoId($url) !== null;
    }

    public static function embedUrl(?string $url, bool $autoplay = false): ?string
    {
        if ($id = static::youtubeId($url)) {
            return 'https://www.youtube-nocookie.com/embed/'.$id.'?rel=0&modestbranding=1'.($autoplay ? '&autoplay=1' : '');
        }

        if ($id = static::vimeoId($url)) {
            return 'https://player.vimeo.com/video/'.$id.($autoplay ? '?autoplay=1' : '');
        }

        return null;
    }

    /** YouTube's best poster frame. Not every video has one — see fallbackThumbnailUrl(). */
    public static function thumbnailUrl(?string $url): ?string
    {
        $id = static::youtubeId($url);

        return $id ? "https://i.ytimg.com/vi/{$id}/maxresdefault.jpg" : null;
    }

    /** Always present, so it is what the preview swaps to when the poster 404s. */
    public static function fallbackThumbnailUrl(?string $url): ?string
    {
        $id = static::youtubeId($url);

        return $id ? "https://i.ytimg.com/vi/{$id}/hqdefault.jpg" : null;
    }

    public static function provider(?string $url): ?string
    {
        return match (true) {
            static::youtubeId($url) !== null => 'YouTube',
            static::vimeoId($url) !== null => 'Vimeo',
            default => null,
        };
    }

    public static function youtubeId(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        // watch?v=, youtu.be/, /embed/, /shorts/ and /live/ all resolve to the same id.
        $patterns = [
            '#youtube\.com/watch\?(?:.*&)?v=([\w-]{6,})#i',
            '#youtu\.be/([\w-]{6,})#i',
            '#youtube(?:-nocookie)?\.com/(?:embed|shorts|live|v)/([\w-]{6,})#i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    public static function vimeoId(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        return preg_match('#vimeo\.com/(?:video/)?(\d{6,})#i', $url, $matches) ? $matches[1] : null;
    }
}
