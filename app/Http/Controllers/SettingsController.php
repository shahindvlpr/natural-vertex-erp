<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function updateGeneral(Request $request)
    {
        // Update general settings
        return redirect()->back()->with('success', 'General settings updated!');
    }

    public function updateCompany(Request $request)
    {
        // Update company settings
        return redirect()->back()->with('success', 'Company settings updated!');
    }

    public function updatePreferences(Request $request)
    {
        // Update preferences
        return redirect()->back()->with('success', 'Preferences updated!');
    }
}