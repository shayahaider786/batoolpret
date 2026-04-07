<?php
  
namespace App\Http\Middleware;
  
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $userType): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Authentication required.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        // Check if user has the required type
        if(auth()->user()->type == $userType){
            return $next($request);
        }
          
        // Redirect unauthorized users instead of returning JSON
        if ($request->expectsJson()) {
            return response()->json(['error' => 'You do not have permission to access this page.'], 403);
        }
        
        return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
    }
}