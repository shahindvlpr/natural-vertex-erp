<?php

if (!function_exists('getCompanyLogo')) {
    function getCompanyLogo()
    {
        $company = \App\Models\Company::first();
        if ($company && $company->logo) {
            return asset('storage/uploads/companies/' . $company->logo);
        }
        return asset('images/default-logo.png');
    }
}

if (!function_exists('getCompanyFavicon')) {
    function getCompanyFavicon()
    {
        $company = \App\Models\Company::first();
        if ($company && $company->favicon) {
            return asset('storage/uploads/companies/' . $company->favicon);
        }
        return asset('images/favicon.ico');
    }
}

if (!function_exists('formatCurrency')) {
    function formatCurrency($amount)
    {
        return '৳ ' . number_format($amount, 2);
    }
}