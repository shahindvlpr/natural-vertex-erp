{{-- app/helpers.php --}}
<?php

use App\Models\Company;

if (!function_exists('getCompanyLogo')) {
    function getCompanyLogo()
    {
        $company = Company::first();
        if ($company && $company->logo) {
            return asset('storage/uploads/companies/' . $company->logo);
        }
        return asset('images/default-logo.png');
    }
}

if (!function_exists('getCompanyFavicon')) {
    function getCompanyFavicon()
    {
        $company = Company::first();
        if ($company && $company->favicon) {
            return asset('storage/uploads/companies/' . $company->favicon);
        }
        return asset('images/favicon.ico');
    }
}