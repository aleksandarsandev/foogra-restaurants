<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'home_hero_title'   => 'Discover & Book',
            'home_hero_subtitle'=> 'The best restaurants at the best price',
            'logo'              => 'img/logo.png',
            'logo_sticky'       => 'img/logo_sticky.png',
            'home_section_1'    => null,
            'banner_bg_desktop' => 'img/banner_bg_desktop.jpg',
            'bg_call_section'   => 'img/bg_call_section.jpg',
            'submit_hero_bg'    => 'img/hero_submit.jpg',
            'submit_about_1'    => 'img/about_1.svg',
            'submit_about_2'    => 'img/about_2.svg',
            'submit_about_3'    => 'img/about_3.svg',
        ];

        foreach ($defaults as $key => $value) {
            SiteSetting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
