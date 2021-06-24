<?php

namespace App\Jobs;

use App\Http\Clients\RefersionApiClient;
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
    public function __construct($product = ['sku' => 'prod-abc-rfsnadid:e99'])
    {
        //TODO remove the object cast. It won't be needed past testing. 
        $this->product = (object) $product;

        $this->refersionApiClient = new RefersionApiClient();

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('Spinning in this bih');

        //get affiliated ID
        $code = app(AffiliateService::class)->parseAffiliateCodeFromShopifySku(config('constants.keywords.rfsnadid'), $this->product->sku);

        \Log::info($code);

        //send api request to post new conversion trigger
        $return = $this->refersionApiClient->postNewConversionTrigger($code, $this->product->sku);

        //based on response end job
        \Log::info($return);
    }
}
