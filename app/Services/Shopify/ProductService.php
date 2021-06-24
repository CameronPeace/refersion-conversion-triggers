<?php

namespace App\Services\Shopify;

use App\Jobs\SendConversionTrigger;

class ProductService
{
    /**
     *
     *
     */
    public function queueProductCreate($product, $keyword = null)
    {
        //TODO rename these variables.
        //TODO decide is making the keyword optional was a good idea
        //TODO decide is class name is accurate.

        if (empty($keyword)) {
            $keyword = config('constants.keywords.rfsnadid');
        }

        //get variants
        $productVariants = $product['variants'];

        \Log::info($productVariants);

        $queueableProducts = $this->filterProductVariantsBySkuKeyword($productVariants, $keyword);

        if (!empty($queueableProducts)) {
            \Log::info($queueableProducts);

            foreach ($queueableProducts as $product) {

                //TODO decide if we want to delete the delay (probably will)
                SendConversionTrigger::dispatch($product)->onConnection('conversion-triggers');
            }
        }

        //TODO Decide what to do here if no job is created.
    }

    /**
     *
     *
     */
    private function filterProductVariantsBySkuKeyword(array $productVariants, string $keyword)
    {
        return array_filter($productVariants, function ($variant) use ($keyword) {
            return strpos($variant['sku'], $keyword);
        });
    }

}
