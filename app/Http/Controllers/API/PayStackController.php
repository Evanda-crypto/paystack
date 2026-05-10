<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Services\PayStackService;

class PayStackController extends Controller
{
    public function callback(string $reference)
    {

        $paystackSercive = new PayStackService;

        $data = json_decode($paystackSercive->verify($reference), true);
        $payment = $data['data'];
        $metadata = $payment['metadata'];
        $subscription_id = $metadata['subscription_id'];
        $subscription = Subscription::find($subscription_id);

        if (! $data['status']) {
            $subscription->update(['status' => 'failed', 'reference' => $payment['reference']]);

            return to_route('packages.index');
        }

        if ($payment['status'] !== 'success') {
            $subscription->update(['status' => 'failed', 'reference' => $payment['reference']]);

            return to_route('packages.index');
        }

        if ($subscription) {
            $subscription->update(['status' => 'success', 'paid_at' => $payment['paid_at'], 'reference' => $payment['reference']]);
        }

        return to_route('subscriptions.index');
    }
}
