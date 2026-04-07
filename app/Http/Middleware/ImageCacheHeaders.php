<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ImageCacheHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only apply to image requests
        $path = $request->path();
        if (preg_match('/\.(jpg|jpeg|png|gif|webp|svg|ico)$/i', $path)) {
            // Cache for 1 year (31536000 seconds)
            $response->header('Cache-Control', 'public, max-age=31536000, immutable');
            $response->header('Expires', gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
            
            // Add ETag for better caching
            if ($response->getContent()) {
                $etag = md5($response->getContent());
                $response->header('ETag', $etag);
                
                // Check if client has cached version
                if ($request->header('If-None-Match') === $etag) {
                    return response('', 304)->withHeaders($response->headers->all());
                }
            }
        }

        return $response;
    }
}

