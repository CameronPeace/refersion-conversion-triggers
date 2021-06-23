<?php

namespace App\Services\Shopify;

use App\Jobs\SendConversionTrigger;

class ProductService
{

    const CONVERSION_TRIGGER_KEYWORD = 'rfsnadid';

    public function queueProductCreate($product)
    {

        //get variants
        $productVariants = $product->variants;
        // $productVariants = $product['variants'];
        //parse variants and check out their sku's

        \Log::info($productVariants);

        $queueableProducts = $this->filterVariantsBySkuKeyword($productVariants);

        if (!empty($queueableProducts)) {
            \Log::info($queueableProducts);
            SendConversionTrigger::dispatch($queueableProducts)->onConnection('conversion-triggers');
        }
    }

    private function filterVariantsBySkuKeyword(array $productVariants)
    {
        return array_filter($productVariants, function ($variant) {
            return strpos($variant->sku, self::CONVERSION_TRIGGER_KEYWORD);
        });
    }

}
