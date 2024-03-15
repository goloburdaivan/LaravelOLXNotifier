<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request): JsonResponse {

        $request->validate([
            'email' => ['required', 'max:255', 'email', 'unique:subscriptions']
        ]);

        return response()->json(['']);
    }
}
