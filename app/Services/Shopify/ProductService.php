<?php

namespace App\Services\Shopify;

use App\Jobs\SendConversionTrigger;

class ProductService
{
    /**
     * Takes an array of products and creates
     * jobs that send conversion triggers for each products sku to
     * refersions api
     * @param array $product
     * @param string|null $keyword
     * @return void
     */
    public function queueProductCreateConversionTriggers(array $product, string $keyword = null)
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

            \Log::info('Shopify ProductCreate webhook: Conversion trigger jobs queued.');

        } else {
            \Log::info('Shopify ProductCreate webhook: No conversion trigger jobs created.');
        }
    }

    /**
     * Iterates through an array of product variants and returns all variants that have
     * sku's containing a specific keyword
     * @param array $productVariants
     * @param string $keyword
     *
     * @return array
     */
    private function filterProductVariantsBySkuKeyword(array $productVariants, string $keyword)
    {
        return array_filter($productVariants, function ($variant) use ($keyword) {
            return strpos($variant['sku'], $keyword);
        });
    }

}
