<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Show company settings page.
     */
    public function index()
    {
        $company = Company::first();
        
        if (!$company) {
            $company = Company::create([
                'name' => 'Natural Vertex Ltd.',
                'email' => 'info@naturalvertex.com',
                'phone' => '+8801700000000',
                'address' => 'Dhaka, Bangladesh',
                'currency' => 'BDT',
                'currency_symbol' => '৳',
                'timezone' => 'Asia/Dhaka',
            ]);
        }

        // Get currencies and timezones
        $currencies = $this->getCurrencies();
        $timezones = $this->getTimezones();

        return view('company.index', compact('company', 'currencies', 'timezones'));
    }

    /**
     * Update company settings.
     */
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'vat_number' => 'nullable|string|max:50',
            'bin_number' => 'nullable|string|max:50',
            'tin_number' => 'nullable|string|max:50',
            'currency' => 'required|string|max:10',
            'currency_symbol' => 'required|string|max:5',
            'timezone' => 'required|string|max:100',
        ]);

        $company->update($validated);

        return redirect()->route('company.settings')
            ->with('success', 'Company settings updated successfully!');
    }

    /**
     * Upload company logo.
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $company = Company::first();
        
        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }

        if ($company->logo) {
            Storage::disk('public')->delete('uploads/companies/' . $company->logo);
        }

        $file = $request->file('logo');
        $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('uploads/companies', $filename, 'public');

        $company->update(['logo' => $filename]);

        return response()->json([
            'success' => true,
            'message' => 'Logo uploaded successfully!'
        ]);
    }

    /**
     * Upload company favicon.
     */
    public function uploadFavicon(Request $request)
    {
        $request->validate([
            'favicon' => 'required|image|mimes:ico,png,jpg|max:512',
        ]);

        $company = Company::first();
        
        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }

        if ($company->favicon) {
            Storage::disk('public')->delete('uploads/companies/' . $company->favicon);
        }

        $file = $request->file('favicon');
        $filename = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('uploads/companies', $filename, 'public');

        $company->update(['favicon' => $filename]);

        return response()->json([
            'success' => true,
            'message' => 'Favicon uploaded successfully!'
        ]);
    }

    /**
     * Upload company signature.
     */
    public function uploadSignature(Request $request)
    {
        $request->validate([
            'signature' => 'required|image|mimes:jpeg,png|max:2048',
        ]);

        $company = Company::first();
        
        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }

        if ($company->signature) {
            Storage::disk('public')->delete('uploads/companies/' . $company->signature);
        }

        $file = $request->file('signature');
        $filename = 'signature_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('uploads/companies', $filename, 'public');

        $company->update(['signature' => $filename]);

        return response()->json([
            'success' => true,
            'message' => 'Signature uploaded successfully!'
        ]);
    }

    /**
     * Delete company logo.
     */
    public function deleteLogo()
    {
        $company = Company::first();
        
        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }

        if ($company->logo) {
            Storage::disk('public')->delete('uploads/companies/' . $company->logo);
            $company->update(['logo' => null]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Logo deleted successfully!'
        ]);
    }

    /**
     * Get all currencies.
     */
    private function getCurrencies()
    {
        return [
            'BDT' => 'Bangladeshi Taka (৳)',
            'USD' => 'US Dollar ($)',
            'EUR' => 'Euro (€)',
            'GBP' => 'British Pound (£)',
            'INR' => 'Indian Rupee (₹)',
            'AUD' => 'Australian Dollar (A$)',
            'CAD' => 'Canadian Dollar (C$)',
            'SGD' => 'Singapore Dollar (S$)',
            'JPY' => 'Japanese Yen (¥)',
            'CNY' => 'Chinese Yuan (¥)',
        ];
    }

    /**
     * Get all timezones.
     */
    private function getTimezones()
    {
        return [
            'Asia/Dhaka' => 'Asia/Dhaka (GMT+6)',
            'Asia/Kolkata' => 'Asia/Kolkata (GMT+5:30)',
            'Asia/Dubai' => 'Asia/Dubai (GMT+4)',
            'Asia/Singapore' => 'Asia/Singapore (GMT+8)',
            'Asia/Tokyo' => 'Asia/Tokyo (GMT+9)',
            'Europe/London' => 'Europe/London (GMT+0)',
            'Europe/Paris' => 'Europe/Paris (GMT+1)',
            'America/New_York' => 'America/New_York (GMT-5)',
            'America/Los_Angeles' => 'America/Los_Angeles (GMT-8)',
            'Australia/Sydney' => 'Australia/Sydney (GMT+11)',
        ];
    }
}