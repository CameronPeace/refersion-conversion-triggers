<?php

namespace App\Services;

class AffiliateService
{
    /**
     *
     *
     */
    public function parseAffiliateCodeFromShopifySku(String $code, string $sku)
    {
        $match = sprintf('%s:', $code);

        if (strpos($sku, $code)) {
            return substr($sku, (strpos($sku, $match) + strlen($match)));
        }

        return false;
    }
}
