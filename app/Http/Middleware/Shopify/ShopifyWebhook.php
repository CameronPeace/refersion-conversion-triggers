<?php

namespace App\Http\Middleware\Shopify;

use Closure;
use Illuminate\Http\Request;

class ShopifyWebhook
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

        if ($request->header('x-shopify-shop-domain') != config('services.shopify.domain')) {
            return response('Forbidden: Invalid domain', 403);
        }

        $signature = $request->header('x-shopify-hmac-sha256');

        if (!isset($signature)) {
            return response('Forbidden', 401);
        }

        $hmac = base64_encode(hash_hmac('sha256', $request->getContent(), config('services.shopify.sign'), true));

        if (!hash_equals($signature, $hmac)) {
            return response('Forbidden: Invalid signature', 401);
        }

        return $next($request);
    }
}
