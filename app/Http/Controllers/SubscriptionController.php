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

    /**
     * @OA\Info(
     *      title="Subscription API",
     *      version="1.0.0",
     *      description="API for subscribing to product updates",
     *      @OA\Contact(
     *          email="admin@example.com"
     *      )
     *  )
     * @OA\Post(
     *     path="/api/subscribe",
     *     summary="Subscribe to product updates",
     *     description="Subscribe to receive updates about product prices",
     *     tags={"Subscription"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Subscription data",
     *         @OA\JsonContent(
     *             required={"email", "url"},
     *             @OA\Property(property="email", type="string", format="email", description="Subscriber's email address"),
     *             @OA\Property(property="url", type="string", format="url", description="URL of the product page"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true, description="Indicates if the subscription was successful"),
     *             @OA\Property(property="message", type="string", example="Subscribed new product for user", description="Success message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Success response, but email not confirmed",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true, description="Indicates if the subscription was successful"),
     *             @OA\Property(property="message", type="string", example="Confirm your email before receiving subscription messages", description="Success message")
     *         )
     *     ),
     * )
     */

    public function subscribe(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'max:255', 'email'],
            'url' => ['required', 'url:https', new OLXUrlValidationRule()]
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()])->setStatusCode(422);
        }

        $data = $request->json()->all();
        $subscription = Subscription::where('email', $data['email'])->first();
        $this->subscriptionService->createSubscription($data['email'], $data['url']);

        if ($subscription == null || !$subscription->confirmed)
            return response()->json(['success' => true, 'message' => 'Confirm your email before receiving subscription messages'])->setStatusCode(403);

        return response()->json(['success' => true, 'message' => 'Subscribed new product for user']);
    }
}
