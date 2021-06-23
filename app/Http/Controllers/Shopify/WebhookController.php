<?php

namespace App\Http\Controllers\Shopify;

use Illuminate\Http\Request;
use App\Services\Shopify\ProductService;

class WebhookController {

    public function productCreate(Request $request) {

        $content = json_decode($request->getContent());

        $service = app(ProductService::class)->queueProductCreate($content);
    }
}