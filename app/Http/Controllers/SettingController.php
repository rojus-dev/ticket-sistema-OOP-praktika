<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function edit()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $reportEmail = Setting::where('key', 'report_email')->value('value');

        return view('settings.edit', compact('reportEmail'));
    }

    public function update(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'report_email' => 'required|email|max:255',
        ]);

        Setting::updateOrCreate(
            ['key' => 'report_email'],
            ['value' => $request->report_email]
        );

        return redirect()->route('settings.edit')->with('success', 'Nustatymai išsaugoti.');
    }
}