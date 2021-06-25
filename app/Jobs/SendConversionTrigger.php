<?php

namespace App\Jobs;

use App\Exceptions\InvalidRefersionApiKeysException;
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

            $sku = $this->product['sku'];

            $code = app(AffiliateService::class)->parseAffiliateCodeFromShopifySku(config('constants.keywords.rfsnadid'), $sku);

            $response = $this->refersionApiClient->postNewConversionTrigger($code, $sku);

            //here we would figure out some logging solution
            \Log::info($response);

        } catch (InvalidRefersionApiKeysException $e) {
            $this->delete();
        } catch (\Exception $e) {
            //we don't know what happened, fail the job to give it another chance.
            \Log::error(sprintf('Refersion conversion trigger job error: %s', $e->getMessage()));
            $this->fail($e);
        }
    }
}
