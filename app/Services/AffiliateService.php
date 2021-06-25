<?php

namespace App\Services;

class AffiliateService
{
    /**
     * Parses a string assumed to be a Sku and returns
     * the affiliate code appended to it
     * @param string $code
     * @param string $sku
     * @return string|bool
     */
    public function parseAffiliateCodeFromShopifySku(string $code, string $sku): mixed
    {
        $match = sprintf('%s:', $code);

        if (strpos($sku, $code)) {
            return substr($sku, (strpos($sku, $match) + strlen($match)));
        }

        return false;
    }
}
