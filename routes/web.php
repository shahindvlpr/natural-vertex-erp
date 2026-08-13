<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AuditLogController;
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
        Route::delete('/favicon', [CompanyController::class, 'deleteFavicon'])->name('favicon.delete');
        Route::delete('/signature', [CompanyController::class, 'deleteSignature'])->name('signature.delete');
    });

    // ============================================
    // USER & PERMISSION MODULE
    // ============================================

    // Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::get('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Roles
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/store', [RoleController::class, 'store'])->name('store');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
        Route::get('/{role}/toggle-status', [RoleController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Permissions
    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::get('/create', [PermissionController::class, 'create'])->name('create');
        Route::post('/store', [PermissionController::class, 'store'])->name('store');
        Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('edit');
        Route::put('/{permission}', [PermissionController::class, 'update'])->name('update');
        Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy');
    });

    // Audit Logs
    Route::prefix('audit')->name('audit.')->group(function () {
        Route::get('/logs', [AuditLogController::class, 'index'])->name('index');
        Route::get('/logs/{log}', [AuditLogController::class, 'show'])->name('show');
        Route::get('/logs/export', [AuditLogController::class, 'export'])->name('export');
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
    

// ============================================
// HR MODULE ROUTES
// ============================================

Route::prefix('hr')->name('hr.')->group(function () {
    
    // Departments
    Route::resource('departments', App\Http\Controllers\DepartmentController::class);
    Route::get('/departments/{department}/toggle-status', [App\Http\Controllers\DepartmentController::class, 'toggleStatus'])->name('departments.toggle-status');
    
    // Designations
    Route::resource('designations', App\Http\Controllers\DesignationController::class);
    Route::get('/designations/{designation}/toggle-status', [App\Http\Controllers\DesignationController::class, 'toggleStatus'])->name('designations.toggle-status');
    
    // Employees
    Route::resource('employees', App\Http\Controllers\EmployeeController::class);
    Route::get('/employees/{employee}/toggle-status', [App\Http\Controllers\EmployeeController::class, 'toggleStatus'])->name('employees.toggle-status');
    
    // Shifts
    Route::resource('shifts', App\Http\Controllers\ShiftController::class);
    Route::get('/shifts/{shift}/toggle-status', [App\Http\Controllers\ShiftController::class, 'toggleStatus'])->name('shifts.toggle-status');
    
    // Holidays
    Route::resource('holidays', App\Http\Controllers\HolidayController::class);
    Route::get('/holidays/{holiday}/toggle-status', [App\Http\Controllers\HolidayController::class, 'toggleStatus'])->name('holidays.toggle-status');
});


// ============================================
// ATTENDANCE MODULE
// ============================================

Route::prefix('attendance')->name('attendance.')->group(function () {
    Route::get('/', [App\Http\Controllers\AttendanceController::class, 'index'])->name('index');
    Route::get('/daily', [App\Http\Controllers\AttendanceController::class, 'daily'])->name('daily');
    Route::post('/check-in', [App\Http\Controllers\AttendanceController::class, 'checkIn'])->name('check-in');
    Route::post('/check-out', [App\Http\Controllers\AttendanceController::class, 'checkOut'])->name('check-out');
    Route::get('/report', [App\Http\Controllers\AttendanceController::class, 'report'])->name('report');
    Route::get('/employee/{employeeId}/details', [App\Http\Controllers\AttendanceController::class, 'employeeDetails'])->name('employee.details');
    Route::post('/update-status', [App\Http\Controllers\AttendanceController::class, 'updateStatus'])->name('update-status');
});

/*
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