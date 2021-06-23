<?php

namespace App\Services\Shopify;

use Illuminate\Support\Facades\Http;

class WebhookService {

    public function queueProductCreate($request){

        // $response = Http::withHeaders(['X-Shopify-Shop-Domain' => 'numa-dev.myshopify.com'])
        // ->withBasicAuth(config('services.shopify.key'), config('services.shopify.password'))
        // ->get("https://numa-dev.myshopify.com/admin/api/2021-04/webhooks/1020170141742.json");

        \Log::info($request->getContent());
    }
    
}
