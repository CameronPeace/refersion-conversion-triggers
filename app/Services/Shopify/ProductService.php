<?php

namespace App\Services\Shopify;

use App\Jobs\SendConversionTrigger;

class ProductService
{
    /**
     * 
     * 
     */
    public function queueProductCreate($product)
    {
        //TODO rename these variables.
        //get variants
        $productVariants = $product['variants'];

        \Log::info($productVariants);

        $queueableProducts = $this->filterProductVariantsBySkuKeyword(config('constants.keywords.rfsnadid'), $productVariants);

        if (!empty($queueableProducts)) {
            \Log::info($queueableProducts);
            
            foreach($queueableProducts as $product ){
                //TODO decide if we want to delete the delay (probably will)
                SendConversionTrigger::dispatch($product)->onConnection('conversion-triggers')->delay(1);
            }
        }

        //TODO Decide what to do here if no job is created. 
    }

    /**
     * 
     * 
     */
    private function filterProductVariantsBySkuKeyword(string $keyword, array $productVariants)
    {
        return array_filter($productVariants, function ($variant) {
            return strpos($variant->sku, $keyword);
        });
    }

    
}
