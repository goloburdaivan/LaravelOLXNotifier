<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
class ConfirmationController extends Controller
{
    public function confirm(string $confirmationToken) : void {
        $subscription = Subscription::where('confirmation_token', $confirmationToken)->first();
        if ($subscription != null) {
            $subscription->confirmed = true;
            $subscription->save();
        }
    }
}
