<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    protected $primaryKey = 'key';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['key', 'value'];

    protected static array $cache = [];

    public static function getValue(string $key): ?string
    {
        if (empty(static::$cache)) {
            static::$cache = static::pluck('value', 'key')->toArray();
        }
        return static::$cache[$key] ?? null;
    }

    public static function imageUrl(string $key, string $default): string
    {
        $value = static::getValue($key);
        if (!$value) return asset($default);
        // img/ prefix = static public asset (default seeded value)
        if (str_starts_with($value, 'img/')) return asset($value);
        return Storage::disk('s3')->url($value);
    }

    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        static::$cache = [];
    }

    public static function definitions(): array
    {
        return [
            'home_hero_title'     => ['type' => 'text',  'label' => 'Home Hero Title',              'default' => 'Discover & Book'],
            'home_hero_subtitle'  => ['type' => 'text',  'label' => 'Home Hero Subtitle',           'default' => 'The best restaurants at the best price'],
            'logo'                => ['type' => 'image', 'label' => 'Logo',                         'default' => 'img/logo.png'],
            'logo_sticky'         => ['type' => 'image', 'label' => 'Logo (Sticky Header)',         'default' => 'img/logo_sticky.png'],
            'home_section_1'      => ['type' => 'image', 'label' => 'Home Hero Background',         'default' => null],
            'banner_bg_desktop'   => ['type' => 'image', 'label' => 'Banner Background',            'default' => 'img/banner_bg_desktop.jpg'],
            'bg_call_section'     => ['type' => 'image', 'label' => 'Call-to-Action Background',    'default' => 'img/bg_call_section.jpg'],
            'submit_hero_bg'      => ['type' => 'image', 'label' => 'Submit Page Hero Background',   'default' => 'img/hero_submit.jpg'],
            'submit_about_1'      => ['type' => 'image', 'label' => 'Submit Page Illustration 1',    'default' => 'img/about_1.svg'],
            'submit_about_2'      => ['type' => 'image', 'label' => 'Submit Page Illustration 2',    'default' => 'img/about_2.svg'],
            'submit_about_3'      => ['type' => 'image', 'label' => 'Submit Page Illustration 3',    'default' => 'img/about_3.svg'],
        ];
    }
}
