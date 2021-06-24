<?php

namespace App\Http\Controllers\Shopify;

use App\Services\Shopify\ProductService;
use Illuminate\Http\Request;

class WebhookController
{
    /**
     * 
     * 
     */
    public function productCreate(Request $request)
    {
        //TODO possible validate & sanitization

        //retrieving json data
        $content = json_decode($request->getContent(), true);

        $service = app(ProductService::class)->queueProductCreateToConversionTriggers($content);

        return response('', 202);
    }
}
