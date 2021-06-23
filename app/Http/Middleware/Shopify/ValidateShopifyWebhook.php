<?php

namespace App\Http\Middleware\Shopify;

use Closure;
use Illuminate\Http\Request;

class ValidateShopifyWebhook
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if($request->header('x-shopify-shop-domain') != config('services.shopify.domain')) {
            return response('Forbidden: Invalid domain', 403);
        }

        // if(!$request->secure()) {
        //     \Log::info('insecure');
        //     return redirect()->secure($request->getRequestUri());
        // }

        $signature = $request->header('x-shopify-hmac-sha256');

        if(!isset($signature)) {
            \Log::info('no sig');
            return response('Forbidden', 403);
        }
        
        $hmac = base64_encode(hash_hmac('sha256', $request->getContent(), config('services.shopify.sign'), true));

        if(!hash_equals($signature, $hmac)) {
            \Log::info('no match');
            return response('Forbidden: Invalid signature', 403);
        }

        return $next($request);
    }
}
