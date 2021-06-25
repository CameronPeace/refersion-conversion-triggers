<?php

namespace App\Http\Clients\Refersion;

use App\Exceptions\InvalidRefersionApiKeysException;
use Illuminate\Support\Facades\Http;

class ApiClient
{

    public $publicKey;
    public $uri;

    private $secretKey;

    private const REQUEST_HEADER_PUBLIC_KEY = 'Refersion-Public-Key';
    private const REQUEST_HEADER_SECRET_KEY = 'Refersion-Secret-Key';

    public function __construct()
    {
        $this->publicKey = config('services.refersion.public');
        $this->secretKey = config('services.refersion.secret');

        $this->client = Http::withHeaders([self::REQUEST_HEADER_PUBLIC_KEY => $this->publicKey, self::REQUEST_HEADER_SECRET_KEY => $this->secretKey])->withOptions(['base_uri' => config('services.refersion.base')]);
    }

    /**
     * Makes a post request to the refersion api that
     * creates a conversion trigger for an affiliate
     * @param string $affiliateCode
     * @param string $sku
     * @return response $response
     */
    public function postNewConversionTrigger(string $affiliateCode, string $sku)
    {
        $response = $this->client->post('/new_affiliate_trigger', [
            'affiliate_code' => $affiliateCode,
            'type' => 'sku',
            'trigger' => $sku,
        ]);

        if ($response->status() == 401) {
            throw new InvalidRefersionApiKeysException($response['error']);
        }

        return $response;
    }
}
