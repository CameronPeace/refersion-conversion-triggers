<?php

namespace App\Http\Controllers\Shopify;

use Illuminate\Http\Request;
use App\Services\Shopify\WebhookService;

class WebhookController {

    public function productCreate(Request $request) {
        
        
        $service = app(WebhookService::class)->makeApiCall($request);
    }
}