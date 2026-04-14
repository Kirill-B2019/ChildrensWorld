<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        $keys = ['contact.phone', 'contact.email', 'contact.address', 'donation.requisites', 'seo.default_description'];
        $settings = [];

        foreach ($keys as $key) {
            $settings[$key] = SiteSetting::getValue('site', $key);
        }

        return view('admin.settings.form', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'settings.contact.phone' => ['nullable', 'string', 'max:100'],
            'settings.contact.email' => ['nullable', 'string', 'max:120'],
            'settings.contact.address' => ['nullable', 'string', 'max:255'],
            'settings.donation.requisites' => ['nullable', 'string', 'max:255'],
            'settings.seo.default_description' => ['nullable', 'string', 'max:255'],
        ]);

        foreach (($data['settings'] ?? []) as $key => $value) {
            SiteSetting::updateOrCreate(
                ['group' => 'site', 'key' => $key, 'locale' => null],
                ['value' => $value]
            );
        }

        return back()->with('status', 'Settings updated.');
    }
}
