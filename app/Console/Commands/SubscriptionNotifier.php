<?php

namespace App\Console\Commands;

use App\Jobs\NotifySubscribersJob;
use App\Models\Product;
use Illuminate\Console\Command;

class SubscriptionNotifier extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify all subscribers about price changings';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $products = Product::all();
        foreach ($products as $product) {
            NotifySubscribersJob::dispatch($product);
        }
    }
}
