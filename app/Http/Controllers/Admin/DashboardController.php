<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::sum('total_price');
        $ordersCount = Order::count();
        $avgCheck = Order::avg('total_price') ?: 0;

        $todayRevenue = Order::whereDate('created_at', now())->sum('total_price');
        $monthRevenue = Order::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('total_price');

        $statusCounters = [];
        foreach (Order::STATUSES as $status) {
            $statusCounters[$status] = Order::where('status', $status)->count();
        }

        $recentOrders = Order::with('user')
            ->latest()
            ->take(6)
            ->get();

        $topCustomers = Order::select(
            'user_id',
            DB::raw('COUNT(*) as orders'),
            DB::raw('SUM(total_price) as spent')
        )
            ->with('user')
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->orderByDesc('spent')
            ->take(5)
            ->get();

        $topProducts = OrderItem::select(
            'product_id',
            DB::raw('SUM(quantity) as qty'),
            DB::raw('SUM(quantity * price) as revenue')
        )
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('qty')
            ->take(5)
            ->get();

        $topCategories = OrderItem::select(
            'categories.name',
            DB::raw('SUM(order_items.quantity) as qty')
        )
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy('categories.name')
            ->orderByDesc('qty')
            ->take(4)
            ->get();

        $monthlySeries = Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_price) as revenue')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(fn ($row) => [
                'month'   => $row->month,
                'revenue' => (float) $row->revenue,
            ]);

        $newUsersCount = User::where('created_at', '>=', now()->startOfMonth())->count();

        $itemsPerOrder = $ordersCount > 0
            ? round(OrderItem::sum('quantity') / $ordersCount, 2)
            : 0;

        $repeatCustomers = User::whereIn('id', function ($query) {
            $query->select('user_id')
                ->from('orders')
                ->groupBy('user_id')
                ->havingRaw('COUNT(*) > 1');
        })->count();

        $ordersWeek = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $ordersWeek[] = [
                'label' => $day->format('D'),
                'date' => $day->toDateString(),
                'orders' => Order::whereDate('created_at', $day)->count(),
                'revenue' => Order::whereDate('created_at', $day)->sum('total_price'),
            ];
        }

        return view('admin.dashboard', compact(
            'totalRevenue',
            'ordersCount',
            'avgCheck',
            'todayRevenue',
            'monthRevenue',
            'statusCounters',
            'recentOrders',
            'topProducts',
            'topCategories',
            'monthlySeries',
            'newUsersCount',
            'itemsPerOrder',
            'repeatCustomers',
            'ordersWeek',
            'topCustomers'
        ));
    }
}
