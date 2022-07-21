<?php
namespace App\Handler;

use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessWebhookJob extends SpatieProcessWebhookJob
{
    public function handle()
    {

        logger('hi this is demo');

        logger($this->webhookCall);
        // $this->webhookCall // contains an instance of `WebhookCall`

        // perform the work here
    }
}