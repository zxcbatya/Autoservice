<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Service;
use Illuminate\Support\Facades\Storage;

final class SiteImages
{
    public static function get(string $key): string
    {
        return asset(config("site.images.{$key}", config('site.images.hero')));
    }

    public static function all(): array
    {
        return collect(config('site.images', []))
            ->mapWithKeys(fn (string $path, string $key) => [$key => asset($path)])
            ->all();
    }

    public static function forService(Service $service): string
    {
        if ($service->image && Storage::disk('public')->exists($service->image)) {
            return asset('storage/'.$service->image);
        }

        $name = mb_strtolower($service->name);

        foreach (config('site.service_placeholders', []) as $keyword => $path) {
            if ($keyword === 'default') {
                continue;
            }
            if (str_contains($name, $keyword)) {
                return asset($path);
            }
        }

        return asset(config('site.service_placeholders.default'));
    }
}
