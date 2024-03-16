<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Rules\OLXUrlValidationRule;
use App\Services\SubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{

    public function __construct(
        protected SubscriptionService $subscriptionService
    )
    {
    }

    public function subscribe(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'max:255', 'email'],
            'url' => ['required', 'url:https', new OLXUrlValidationRule()]
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $data = $request->json()->all();
        $subscription = Subscription::where('email', $data['email'])->first();
        $this->subscriptionService->createSubscription($data['email'], $data['url']);

        if ($subscription == null || !$subscription->confirmed)
            return response()->json(['success' => true, 'message' => 'Confirm your email before receiving subscription messages']);

        return response()->json(['success' => true, 'message' => 'Subscribed new product for user']);
    }
}
