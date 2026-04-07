<?php
  
namespace App\Http\Controllers;
  
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        $user = Auth::user();
        
        // Get all orders for the user (by user_id or by email if user_id is null)
        // This ensures orders placed before login are also shown
        $orders = Order::with('items.product.images')
            ->where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere(function($q) use ($user) {
                          $q->where('email', $user->email)
                            ->whereNull('user_id');
                      });
            })
            ->latest()
            ->paginate(10);
        
        // Optimize statistics - combine into single query and cache for 5 minutes
        $stats = Cache::remember("user.stats.{$user->id}", 300, function () use ($user) {
            return Order::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere(function($q) use ($user) {
                          $q->where('email', $user->email)
                            ->whereNull('user_id');
                      });
            })
            ->selectRaw('
                COUNT(*) as total_orders,
                SUM(CASE WHEN status != "cancelled" THEN total ELSE 0 END) as total_spent,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending_orders,
                SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_orders
            ')
            ->first();
        });
        
        $totalOrders = $stats->total_orders ?? 0;
        $totalSpent = $stats->total_spent ?? 0;
        $pendingOrders = $stats->pending_orders ?? 0;
        $completedOrders = $stats->completed_orders ?? 0;
        
        return view('home', compact(
            'orders',
            'totalOrders',
            'totalSpent',
            'pendingOrders',
            'completedOrders'
        ));
    } 
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome(): View
    {
        return view('adminHome');
    }
  
}