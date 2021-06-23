<?php

namespace App\Services\Shopify;

use Illuminate\Support\Facades\Http;

class ProductService {

    const CONVERSION_TRIGGER_KEYWORD = 'rfsnadid';

    public function queueProductCreate($product){

        //get variants
        $productVariants = $product->variants;    
        // $productVariants = $product['variants'];
        //parse variants and check out their sku's
        
        \Log::info($productVariants);

        $queueableProducts = $this->filterVariantsBySku($productVariants);

        
        \Log::info($queueableProducts);
    }

    private function filterVariantsBySku(array $productVariants)
    {
        return array_filter($productVariants, function($variant) {
            return strpos($variant->sku, self::CONVERSION_TRIGGER_KEYWORD);  
        });
    }
    
}
