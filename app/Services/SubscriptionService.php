<?php
namespace App\Services;
use App\Mail\ConfirmationMail;
use App\Models\Product;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SubscriptionService
{
    public function createSubscription(string $email, string $productUrl): void {
        $subscription = Subscription::firstOrCreate(['email' => $email], [
            'confirmation_token' => Str::random(64),
            'email' => $email
        ]);

        if ($subscription->wasRecentlyCreated) {
            Mail::to($subscription->email)->send(new ConfirmationMail(route('mail.confirm', [
                'confirmationToken' => $subscription->confirmation_token
            ])));
        }

        $product = Product::firstOrCreate(['url' => $productUrl]);
        if (!$subscription->products()->where('product_id', $product->id)->exists()) {
            $subscription->products()->attach($product->id);
        }
    }
}
