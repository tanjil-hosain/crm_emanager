<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;


class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('crm_emanager.backend.Settings.create', compact('setting'));
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'logo_type' => 'required|in:icon,wordmark',
            'contact_email' => 'nullable|email|max:255',
        ]);

        $setting = Setting::first() ?? new Setting();
        $setting->site_name = $validated['site_name'];
        $setting->logo_type = $validated['logo_type'];
        $setting->site_name = $validated['logo_type'] == 'icon'
            ? ($validated['site_name'] ?? null)
            : null;
        $setting->contact_email = $validated['contact_email'] ?? null;

        if ($request->hasFile('logo')) {

            $newLogo = uploadImage($request->file('logo'), 'uploads/logo', $setting->logo);

            $setting->logo = $newLogo;
        }

        $setting->save();

        return redirect()->back()->with('success', 'Settings Updated Successfully');
    }
}
