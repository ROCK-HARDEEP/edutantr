<?php

namespace App\Support;

class VideoEmbed
{
    private const IFRAME_PATTERN = '/^<iframe\s+.*?src=["\']https?:\/\/[^\s"\'<>]+["\'].*?><\/iframe>$/i';

    public static function isValid(?string $link): bool
    {
        if ($link === null || trim($link) === '') {
            return true;
        }

        $link = trim($link);

        if (self::isIframe($link)) {
            return true;
        }

        return self::resolveEmbedUrl($link) !== null;
    }

    public static function normalize(?string $link): ?string
    {
        if ($link === null || trim($link) === '') {
            return null;
        }

        $link = trim($link);

        if (self::isIframe($link)) {
            return self::customizeIframe($link);
        }

        $embedUrl = self::resolveEmbedUrl($link);

        if ($embedUrl === null) {
            return null;
        }

        if (self::isDirectVideoUrl($embedUrl)) {
            return self::buildVideoElement($embedUrl);
        }

        return self::buildIframe($embedUrl);
    }

    private static function isIframe(string $link): bool
    {
        return (bool) preg_match(self::IFRAME_PATTERN, $link);
    }

    private static function resolveEmbedUrl(string $input): ?string
    {
        if (! filter_var($input, FILTER_VALIDATE_URL)) {
            return null;
        }

        $host = strtolower(parse_url($input, PHP_URL_HOST) ?? '');
        $path = parse_url($input, PHP_URL_PATH) ?? '';

        if (str_contains($host, 'youtube.com') || str_contains($host, 'youtu.be')) {
            $videoId = self::extractYoutubeId($input);

            return $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
        }

        if (str_contains($host, 'vimeo.com')) {
            if (preg_match('/\/(\d+)(?:\?|$)/', $path, $matches)) {
                return "https://player.vimeo.com/video/{$matches[1]}";
            }
        }

        if (self::isDirectVideoUrl($input)) {
            return $input;
        }

        return null;
    }

    private static function extractYoutubeId(string $url): ?string
    {
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            return $matches[1];
        }

        parse_str(parse_url($url, PHP_URL_QUERY) ?? '', $query);

        if (! empty($query['v']) && preg_match('/^[a-zA-Z0-9_-]{11}$/', $query['v'])) {
            return $query['v'];
        }

        return null;
    }

    private static function isDirectVideoUrl(string $url): bool
    {
        $path = parse_url($url, PHP_URL_PATH) ?? '';

        return (bool) preg_match('/\.(mp4|webm|ogg|m3u8)(\?.*)?$/i', $path);
    }

    private static function buildIframe(string $embedUrl): string
    {
        $safeUrl = htmlspecialchars($embedUrl, ENT_QUOTES, 'UTF-8');

        return '<iframe width="100%" height="450" src="' . $safeUrl . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    }

    private static function buildVideoElement(string $videoUrl): string
    {
        $safeUrl = htmlspecialchars($videoUrl, ENT_QUOTES, 'UTF-8');

        return '<video width="100%" height="450" controls playsinline><source src="' . $safeUrl . '"></video>';
    }

    private static function customizeIframe(string $mediaLink): string
    {
        $customWidth = '100%';
        $customHeight = '450';

        $mediaLink = preg_replace('/\s*title="[^"]*"/', '', $mediaLink);

        return preg_replace(
            ['/width="\d+"/', '/height="\d+"/'],
            ["width=\"$customWidth\"", "height=\"$customHeight\""],
            $mediaLink
        );
    }
}
