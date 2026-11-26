<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

/**
 * Resolves the MIS / Library API connection settings at runtime.
 *
 * The Laravel admin settings page stores an override in `system_settings`.
 * When a key is absent or blank, the value from config/services.php
 * (MIS_API_* environment variables) is used, so existing deployments keep
 * working without editing .env or re-configuring anything.
 */
class MisSettings
{
    public const URL_KEY = 'student_api_url';

    public const PATH_KEY = 'student_api_path';

    public const API_KEY_KEY = 'mis_api_key';

    /** @var array<string, string>|null */
    private ?array $cache = null;

    /**
     * Base URL, without a trailing slash.
     */
    public function baseUrl(): string
    {
        $value = $this->setting(self::URL_KEY);

        if ($value === '') {
            $value = (string) config('services.mis.url', 'http://localhost:5080');
        }

        return rtrim(trim($value), '/');
    }

    /**
     * Student lookup path. {cardId} / {cardNo} are replaced at request time.
     */
    public function studentPath(): string
    {
        $value = $this->setting(self::PATH_KEY);

        if ($value === '') {
            $value = (string) config('services.mis.student_path', '/api/students/{cardId}');
        }

        $value = trim($value);

        if ($value === '') {
            return '/api/students/{cardId}';
        }

        // Allow admins to paste a path with or without leading slash.
        if (! str_starts_with($value, '/') && ! str_starts_with($value, 'http://') && ! str_starts_with($value, 'https://')) {
            $value = '/'.$value;
        }

        return $value;
    }

    public function apiKey(): string
    {
        $this->setting(self::URL_KEY); // ensure cache loaded
        if (is_array($this->cache) && array_key_exists(self::API_KEY_KEY, $this->cache)) {
            return trim((string) $this->cache[self::API_KEY_KEY]);
        }

        return trim((string) config('services.mis.key', ''));
    }

    public function timeout(): float
    {
        return (float) config('services.mis.timeout', 3);
    }

    /**
     * The endpoint currently in use, for display on the settings page.
     * With no card supplied it keeps the {cardId} placeholder visible.
     */
    public function endpointFor(string $cardId = '{cardId}'): string
    {
        $base = $this->baseUrl();
        $replace = ($cardId === '{cardId}' || $cardId === '{cardNo}')
            ? $cardId
            : rawurlencode($cardId);

        // Backward-compatible: if the base URL already contains a card placeholder,
        // treat it as a full endpoint template.
        if ($this->containsCardPlaceholder($base)) {
            return str_replace(['{cardId}', '{cardNo}'], $replace, $base);
        }

        $path = str_replace(
            ['{cardId}', '{cardNo}'],
            $replace,
            $this->studentPath()
        );

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return $base.'/'.ltrim($path, '/');
    }

    public function containsCardPlaceholder(string $value): bool
    {
        return str_contains($value, '{cardId}') || str_contains($value, '{cardNo}');
    }

    private function setting(string $key): string
    {
        if ($this->cache === null) {
            $this->cache = DB::table('system_settings')
                ->whereIn('key', [self::URL_KEY, self::PATH_KEY, self::API_KEY_KEY])
                ->pluck('value', 'key')
                ->map(fn ($value) => trim((string) $value))
                ->all();
        }

        return $this->cache[$key] ?? '';
    }
}
