<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\PriceParsingService;
use Illuminate\Console\Command;

class SubscriptionNotifier extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:subscription-notifier';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = Product::all();
        foreach ($products as $product) {
            $price = app(PriceParsingService::class)->getPrice($product->url);
            if ($price != $product->price) {
                error_log("------ Product {$product->url}");
                $product->notifyAll($price);
            }
        }
    }
}
