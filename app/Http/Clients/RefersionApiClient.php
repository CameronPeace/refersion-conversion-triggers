<?php

namespace App\Http\Clients;

use Illuminate\Support\Facades\Http;

class RefersionApiClient
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

    public function getAffiliateById()
    {
        $response =  $this->client->post('/get_affiliate',[
            'affiliate_code' => 'e99'
        ]);
        
        // $response =  $this->client->post('/list_affiliates',[
        //     'limit' => '3'
        // ]);
        return $response->body();
    }

    public function postNewAffiliateTrigger() {
        $response = $this->client->post('/new_affiliate_trigger'), [
            'affiliate_code' => '',
            'type' => 'sku',
            'trigger' => ''
        ]);
    }
}