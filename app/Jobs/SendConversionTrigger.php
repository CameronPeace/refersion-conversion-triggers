<?php

namespace App\Jobs;

use App\Http\Clients\Refersion\ApiClient;
use App\Services\AffiliateService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendConversionTrigger implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $product;

    private $refersionApiClient;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product)
    {
        //prod-abc-rfsnadid:e99
        $this->product = $product;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {

            $this->refersionApiClient = new ApiClient();

            \Log::info('Spinning in this bih');

            $sku = $this->product['sku'];

            //get affiliated code
            $code = app(AffiliateService::class)->parseAffiliateCodeFromShopifySku(config('constants.keywords.rfsnadid'), $sku);

            //send api request to post new conversion trigger
            $return = $this->refersionApiClient->postNewConversionTrigger($code, $sku);

            //based on response end job
            \Log::info($return);
        } catch (\Exception$e) {
            \Log::error($e);
        }

    }
}
