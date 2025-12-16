<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->withCount('orders')
            ->withSum('orders as total_spent', 'total_price')
            ->with(['orders' => fn ($q) => $q->latest()->limit(1)])
            ->orderByDesc('orders_count')
            ->get();

        $totalUsers = $users->count();
        $adminCount = $users->where('role', 'admin')->count();
        $newThisMonth = User::where('created_at', '>=', now()->startOfMonth())->count();
        $repeatCustomers = User::whereIn('id', function ($query) {
            $query->select('user_id')
                ->from('orders')
                ->groupBy('user_id')
                ->havingRaw('COUNT(*) > 1');
        })->count();

        $topSpender = $users->sortByDesc('total_spent')->first();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'adminCount',
            'newThisMonth',
            'repeatCustomers',
            'topSpender'
        ));
    }
}
