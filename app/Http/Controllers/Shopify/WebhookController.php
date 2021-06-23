<?php

namespace App\Http\Controllers\Shopify;

use App\Services\Shopify\ProductService;
use Illuminate\Http\Request;

class WebhookController
{

    public function productCreate(Request $request)
    {

        $content = json_decode($request->getContent());

        $service = app(ProductService::class)->queueProductCreate($content);
    }
}
