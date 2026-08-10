<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ============================================
// PUBLIC ROUTES
// ============================================

// Home Redirect
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// ============================================
// AUTHENTICATION ROUTES
// ============================================

// Login Routes
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

// Two Factor Authentication
Route::controller(TwoFactorController::class)->prefix('2fa')->name('2fa.')->group(function () {
    Route::get('/verify', 'showVerifyForm')->name('verify');
    Route::post('/verify', 'verify');
    Route::post('/resend', 'resendCode')->name('resend');
});

// Password Reset
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('/forgot-password', 'showLinkRequestForm')->name('password.request');
    Route::post('/forgot-password', 'sendResetLinkEmail')->name('password.email');
    Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset');
    Route::post('/reset-password', 'reset')->name('password.update');
});

// ============================================
// SOCIAL LOGIN ROUTES (Optional)
// ============================================

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('auth.google');

Route::get('/auth/google/callback', function () {
    $user = Socialite::driver('google')->user();
    // Handle user login/registration
    return redirect()->route('dashboard.index');
});

// ============================================
// PROTECTED ROUTES (Requires Authentication)
// ============================================

Route::middleware(['auth'])->group(function () {
    
    // ============================================
    // DASHBOARD
    // ============================================
    
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/chart-data', [DashboardController::class, 'getChartData'])->name('chart');
    });

    // ============================================
    // COMPANY SETTINGS
    // ============================================
    
    Route::prefix('company')->name('company.')->group(function () {
        Route::get('/settings', [CompanyController::class, 'index'])->name('settings');
        Route::put('/update/{company}', [CompanyController::class, 'update'])->name('update');
        Route::post('/logo', [CompanyController::class, 'uploadLogo'])->name('logo.upload');
        Route::post('/favicon', [CompanyController::class, 'uploadFavicon'])->name('favicon.upload');
        Route::post('/signature', [CompanyController::class, 'uploadSignature'])->name('signature.upload');
        Route::delete('/logo', [CompanyController::class, 'deleteLogo'])->name('logo.delete');
    });

    // ============================================
    // PROFILE (Simple - Without Controller)
    // ============================================
    
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', function () {
            return view('profile.index');
        })->name('index');
    });

    // ============================================
    // SETTINGS (Simple - Without Controller)
    // ============================================
    
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', function () {
            return view('settings.index');
        })->name('index');
    });

    // ============================================
    // OTHER MODULES (Commented - Will be added later)
    // ============================================
    
    /*
    // User Management Module
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\UserController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
    });

    // HR Module
    Route::prefix('hr')->name('hr.')->group(function () {
        Route::resource('employees', App\Http\Controllers\EmployeeController::class);
        Route::resource('departments', App\Http\Controllers\DepartmentController::class);
        Route::resource('designations', App\Http\Controllers\DesignationController::class);
        Route::resource('shifts', App\Http\Controllers\ShiftController::class);
        Route::resource('holidays', App\Http\Controllers\HolidayController::class);
    });

    // Attendance Module
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', [App\Http\Controllers\AttendanceController::class, 'index'])->name('index');
        Route::post('/check-in', [App\Http\Controllers\AttendanceController::class, 'checkIn'])->name('check-in');
        Route::post('/check-out', [App\Http\Controllers\AttendanceController::class, 'checkOut'])->name('check-out');
        Route::get('/report', [App\Http\Controllers\AttendanceController::class, 'report'])->name('report');
    });

    // Inventory Module
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::resource('categories', App\Http\Controllers\CategoryController::class);
        Route::resource('brands', App\Http\Controllers\BrandController::class);
        Route::resource('units', App\Http\Controllers\UnitController::class);
        Route::resource('products', App\Http\Controllers\ProductController::class);
        Route::get('/products/stock-alert', [App\Http\Controllers\ProductController::class, 'stockAlert'])->name('products.stock-alert');
    });

    // Production Module
    Route::prefix('production')->name('production.')->group(function () {
        Route::resource('bom', App\Http\Controllers\BillOfMaterialController::class);
        Route::resource('orders', App\Http\Controllers\ProductionOrderController::class);
        Route::resource('machines', App\Http\Controllers\MachineController::class);
        Route::get('/quality-checks', [App\Http\Controllers\QualityCheckController::class, 'index'])->name('quality.index');
    });

    // Sales Module
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::get('/pos', [App\Http\Controllers\POSController::class, 'index'])->name('pos');
        Route::resource('orders', App\Http\Controllers\SalesOrderController::class);
        Route::resource('invoices', App\Http\Controllers\SalesInvoiceController::class);
        Route::resource('returns', App\Http\Controllers\SalesReturnController::class);
    });

    // Customer Module
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::resource('customers', App\Http\Controllers\CustomerController::class);
        Route::get('/{customer}/ledger', [App\Http\Controllers\CustomerController::class, 'ledger'])->name('ledger');
        Route::post('/{customer}/collection', [App\Http\Controllers\CustomerController::class, 'collection'])->name('collection');
    });

    // Accounts Module
    Route::prefix('accounts')->name('accounts.')->group(function () {
        Route::resource('chart-of-accounts', App\Http\Controllers\ChartOfAccountController::class);
        Route::resource('vouchers', App\Http\Controllers\VoucherController::class);
        Route::get('/trial-balance', [App\Http\Controllers\AccountReportController::class, 'trialBalance'])->name('trial-balance');
        Route::get('/balance-sheet', [App\Http\Controllers\AccountReportController::class, 'balanceSheet'])->name('balance-sheet');
        Route::get('/profit-loss', [App\Http\Controllers\AccountReportController::class, 'profitLoss'])->name('profit-loss');
    });

    // Expense Module
    Route::prefix('expense')->name('expense.')->group(function () {
        Route::get('/', [App\Http\Controllers\ExpenseController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\ExpenseController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\ExpenseController::class, 'store'])->name('store');
        Route::get('/{expense}/edit', [App\Http\Controllers\ExpenseController::class, 'edit'])->name('edit');
        Route::put('/{expense}', [App\Http\Controllers\ExpenseController::class, 'update'])->name('update');
        Route::delete('/{expense}', [App\Http\Controllers\ExpenseController::class, 'destroy'])->name('destroy');
        Route::get('/report', [App\Http\Controllers\ExpenseController::class, 'report'])->name('report');
    });

    // Reports Module
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', [App\Http\Controllers\ReportController::class, 'sales'])->name('sales');
        Route::get('/purchase', [App\Http\Controllers\ReportController::class, 'purchase'])->name('purchase');
        Route::get('/inventory', [App\Http\Controllers\ReportController::class, 'inventory'])->name('inventory');
        Route::get('/attendance', [App\Http\Controllers\ReportController::class, 'attendance'])->name('attendance');
        Route::get('/profit', [App\Http\Controllers\ReportController::class, 'profit'])->name('profit');
        Route::get('/expense', [App\Http\Controllers\ReportController::class, 'expense'])->name('expense');
    });

    // Notification Routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [App\Http\Controllers\NotificationController::class, 'index'])->name('index');
        Route::post('/{notification}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('read');
        Route::post('/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('read-all');
    });
    */
});

// ============================================
// FALLBACK ROUTE (404 Page)
// ============================================

Route::fallback(function () {
    return view('errors.404');
});

// ============================================
// TESTING ROUTES (Only in development)
// ============================================

if (app()->environment('local')) {
    Route::get('/test', function () {
        return view('test');
    })->name('test');
}