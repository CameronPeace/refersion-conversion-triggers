<?php

namespace App\Http\Controllers\Shopify;

use App\Services\Shopify\ProductService;
use Illuminate\Http\Request;

class WebhookController
{
    /**
     * Opening for Shopify's ProductCreate webhook
     * @param request $request
     * @return response
     */
    public function productCreate(Request $request)
    {
        //TODO possible validate & sanitization
        try {

            \Log::info('Data incoming from Shopify ProductCreate Webhook');
            //retrieving json data
            $content = json_decode($request->getContent(), true);

            $service = app(ProductService::class)->queueProductCreateConversionTriggers($content);

            return response('', 202);
        } catch (\Exception $e) {
            \Log::error(sprintf('Could not process data from Shopify ProductCreate webhook => %s', $e->getMessage()));

            return response('Error occurred', 500);
        }

    }
}
