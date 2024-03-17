<?php

namespace App\Jobs;

use App\Models\Product;
use App\Services\PriceParsingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifySubscribersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    private Product $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle(PriceParsingService $parsingService): void
    {
        Log::info("Checking product: {$this->product->url}");
        $price = $parsingService->getPrice($this->product->url);
        if ($price != $this->product->price) {
            $this->product->price = $price;
            $this->product->save();
            $this->product->notifyAll($price);
        }
    }
}
