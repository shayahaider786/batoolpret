<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Review;
use Carbon\Carbon;

class backendController extends Controller
{
    public function index(){
        // Get total counts
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $activeProducts = Product::where('status', 'active')->count();
        $activeCategories = Category::where('status', 'active')->count();
        
        // Get counts from last month for percentage calculation
        $lastMonth = Carbon::now()->subMonth();
        $productsLastMonth = Product::where('created_at', '<=', $lastMonth)->count();
        $categoriesLastMonth = Category::where('created_at', '<=', $lastMonth)->count();
        
        // Calculate percentage change
        $productChange = $productsLastMonth > 0 
            ? round((($totalProducts - $productsLastMonth) / $productsLastMonth) * 100, 1)
            : ($totalProducts > 0 ? 100 : 0);
        
        $categoryChange = $categoriesLastMonth > 0
            ? round((($totalCategories - $categoriesLastMonth) / $categoriesLastMonth) * 100, 1)
            : ($totalCategories > 0 ? 100 : 0);
        
        // Orders Statistics
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');
        
        // Order Status Counts
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        
        // Calculate percentages for order status
        $totalOrdersForPercentage = $totalOrders > 0 ? $totalOrders : 1;
        $pendingPercentage = ($pendingOrders / $totalOrdersForPercentage) * 100;
        $processingPercentage = ($processingOrders / $totalOrdersForPercentage) * 100;
        $completedPercentage = ($completedOrders / $totalOrdersForPercentage) * 100;
        $cancelledPercentage = ($cancelledOrders / $totalOrdersForPercentage) * 100;
        
        // Recent Orders (last 10)
        $recentOrders = Order::with('items.product')
            ->latest()
            ->limit(10)
            ->get();
        
        // Sales Chart Data (Last 7 days)
        $salesData = [];
        $salesLabels = [];
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $salesLabels[] = $date->format('D'); // Mon, Tue, etc.
            
            $dayTotal = Order::where('status', '!=', 'cancelled')
                ->whereDate('created_at', $date->format('Y-m-d'))
                ->sum('total');
            
            $salesData[] = (float) $dayTotal;
        }
        
        // Additional Statistics
        $newContacts = Contact::where('status', 'new')->count();
        $pendingReviews = Review::where('status', 'pending')->count();
        
        // Revenue comparison (this month vs last month)
        $thisMonthRevenue = Order::where('status', '!=', 'cancelled')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total');
        
        $lastMonthRevenue = Order::where('status', '!=', 'cancelled')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('total');
        
        $revenueChange = $lastMonthRevenue > 0 
            ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : ($thisMonthRevenue > 0 ? 100 : 0);
        
        return view('backend.index', compact(
            'totalProducts',
            'totalCategories',
            'activeProducts',
            'activeCategories',
            'productChange',
            'categoryChange',
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'cancelledOrders',
            'pendingPercentage',
            'processingPercentage',
            'completedPercentage',
            'cancelledPercentage',
            'recentOrders',
            'salesData',
            'salesLabels',
            'newContacts',
            'pendingReviews',
            'revenueChange'
        ));
    }
}
