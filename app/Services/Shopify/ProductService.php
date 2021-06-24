<?php

namespace App\Services\Shopify;

use App\Jobs\SendConversionTrigger;

class ProductService
{
    /**
     *
     *
     */
    public function queueProductCreateToConversionTriggers($product, $keyword = null)
    {
        if (empty($keyword)) {
            $keyword = config('constants.keywords.rfsnadid');
        }

        //get variants
        $productVariants = $product['variants'];

        $queueableProducts = $this->filterProductVariantsBySkuKeyword($productVariants, $keyword);

        if (!empty($queueableProducts)) {

            foreach ($queueableProducts as $product) {
                SendConversionTrigger::dispatch($product)->onConnection('conversion-triggers');
            }

            \Log::info('Shopify product webhook: Conversion trigger jobs queued.');

        } else {
            \Log::info('Shopify product webhook: No conversion trigger jobs created.');
        }
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
