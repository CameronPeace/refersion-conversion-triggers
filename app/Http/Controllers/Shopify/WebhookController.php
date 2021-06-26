<?php

namespace App\Http\Controllers\Shopify;

use App\Services\Shopify\ProductService;
use Illuminate\Http\Request;

class WebhookController
{
    /**
     * Opening for Shopify's ProductsCreate webhook
     * @param request $request
     * @return response
     */
    public function productsCreate(Request $request)
    {
        try {

            \Log::info('Data incoming from Shopify ProductsCreate Webhook');
            //retrieving json data
            $content = json_decode($request->getContent(), true);

            app(ProductService::class)->queueProductsCreateConversionTriggers($content);

            return response('', 202);
        } catch (\Exception $e) {
            \Log::error(sprintf('Could not process data from Shopify ProductsCreate webhook => %s', $e->getMessage()));

            return response('Error occurred', 500);
        }

    }
}
