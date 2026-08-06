<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Expense;
use App\Models\ProductionOrder;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get today's date
        $today = now()->toDateString();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Basic statistics with error handling
        try {
            $stats = [
                'today_sales' => 0, // Sale::whereDate('created_at', $today)->sum('total_amount') ?? 0,
                'today_expense' => 0, // Expense::whereDate('created_at', $today)->sum('amount') ?? 0,
                'today_collection' => 0, // Sale::whereDate('created_at', $today)->sum('paid_amount') ?? 0,
                'current_stock_value' => 0, // Stock::sum(DB::raw('quantity * unit_cost')) ?? 0,
                'low_stock_products' => 0, // Product::whereColumn('min_stock', '>', DB::raw('(SELECT SUM(available_quantity) FROM stocks WHERE stocks.product_id = products.id)'))->count(),
                'pending_purchase' => 0,
                'pending_delivery' => 0,
                'employee_attendance' => 0, // Attendance::whereDate('date', $today)->count(),
                'production_status' => 0, // ProductionOrder::where('status', 'in_progress')->count(),
            ];
        } catch (\Exception $e) {
            $stats = [
                'today_sales' => 0,
                'today_expense' => 0,
                'today_collection' => 0,
                'current_stock_value' => 0,
                'low_stock_products' => 0,
                'pending_purchase' => 0,
                'pending_delivery' => 0,
                'employee_attendance' => 0,
                'production_status' => 0,
            ];
        }

        // Monthly Sales Data - Sample data for now
        $monthlySales = $this->getSampleMonthlyData();
        $monthlyExpenses = $this->getSampleMonthlyData();

        // Top Selling Products - Empty for now
        $topProducts = collect();

        // Recent Activities
        try {
            $recentActivities = AuditLog::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        } catch (\Exception $e) {
            $recentActivities = collect();
        }

        return view('dashboard.index', compact(
            'stats',
            'monthlySales',
            'monthlyExpenses',
            'topProducts',
            'recentActivities'
        ));
    }

    /**
     * Get sample monthly data for chart.
     */
    private function getSampleMonthlyData()
    {
        $data = [];
        for ($i = 1; $i <= 30; $i++) {
            $data[$i] = rand(500, 3000);
        }
        return $data;
    }

    /**
     * Get chart data for AJAX request.
     */
    public function getChartData(Request $request)
    {
        $type = $request->get('type', 'monthly');
        $data = [];

        switch ($type) {
            case 'monthly':
                $data = [
                    'labels' => ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7', 'Day 8', 'Day 9', 'Day 10'],
                    'sales' => [1200, 1500, 1800, 1400, 2000, 1600, 2200, 1900, 2100, 2500],
                    'expenses' => [800, 900, 1000, 850, 1100, 950, 1200, 1050, 1150, 1300],
                ];
                break;

            case 'weekly':
                $data = [
                    'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    'sales' => [1200, 1500, 1800, 1400, 2000, 1600, 2200],
                    'expenses' => [800, 900, 1000, 850, 1100, 950, 1200],
                ];
                break;
        }

        return response()->json($data);
    }

    /**
     * Analytics page.
     */
    public function analytics()
    {
        return view('dashboard.analytics');
    }

    /**
     * Recent activities page.
     */
    public function recentActivities()
    {
        try {
            $activities = AuditLog::with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        } catch (\Exception $e) {
            $activities = collect();
        }

        return view('dashboard.activities', compact('activities'));
    }
}