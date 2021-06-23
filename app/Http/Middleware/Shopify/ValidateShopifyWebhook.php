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

        $signature = $request->header('x-shopify-hmac-sha256');

        if(!isset($signature)) {
            return response('Forbidden', 403);
        }

        $body = $request->getContent();
        
        $hmac = base64_encode(hash_hmac('sha256', $body, config('services.shopify.sign'), true));

        if($signature != $hmac) {
            return response('Forbidden: invalid signature', 403);
        }

        return $next($request);
    }
}
