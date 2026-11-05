<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_currency' => 'required|string|in:IDR,USD',
            'tax_percentage' => 'required|numeric|min:0',
            'min_topup' => 'required|numeric|min:0',
            'order_timeout' => 'required|integer|min:5|max:120',
            'max_order_per_day' => 'required|integer|min:1|max:50',
        ]);

        // Update settings
        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()
            ->with('success', 'Pengaturan berhasil diperbarui!');
    }

    public function updateHours(Request $request)
    {
        $validated = $request->validate([
            'monday_open' => 'required|string',
            'monday_close' => 'required|string',
            'tuesday_open' => 'required|string',
            'tuesday_close' => 'required|string',
            'wednesday_open' => 'required|string',
            'wednesday_close' => 'required|string',
            'thursday_open' => 'required|string',
            'thursday_close' => 'required|string',
            'friday_open' => 'required|string',
            'friday_close' => 'required|string',
            'saturday_open' => 'required|string',
            'saturday_close' => 'required|string',
            'sunday_open' => 'required|string',
            'sunday_close' => 'required|string',
        ]);

        // Update store hours
        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()
            ->with('success', 'Jam operasional berhasil diperbarui!');
    }
}
