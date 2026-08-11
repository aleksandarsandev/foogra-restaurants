<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit()
    {
        $definitions = SiteSetting::definitions();
        $settings = SiteSetting::pluck('value', 'key');
        return view('admin.settings.edit', compact('definitions', 'settings'));
    }

    public function update(Request $request)
    {
        $imageRules = collect(SiteSetting::definitions())
            ->filter(fn($def) => $def['type'] === 'image')
            ->mapWithKeys(fn($def, $key) => ["images.$key" => 'nullable|image|max:2048'])
            ->toArray();

        $request->validate($imageRules);

        foreach (SiteSetting::definitions() as $key => $def) {
            if ($def['type'] === 'text') {
                SiteSetting::set($key, $request->input("texts.$key") ?? $def['default']);
            } elseif ($request->hasFile("images.$key")) {
                $path = $request->file("images.$key")->store('settings', 's3');
                SiteSetting::set($key, $path);
            } elseif ($request->boolean("remove.$key")) {
                SiteSetting::set($key, $def['default']);
            }
        }

        return redirect()->route('admin.settings.edit')->with('success', 'Site settings updated.');
    }
}
