<?php

namespace App\Services;

use App\Models\Package;
use Illuminate\Support\Facades\Http;

class PayStackService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function initiate(string $email, string $amount, Package $package)
    {
        $response = Http::withToken(config('services.paystack.secret_key'))
            ->post(config('services.paystack.base_url').'/transaction/initialize', [
                'email' => $email,
                'amount' => $amount,
                'callback_url' => route('payment.callback'),

                'metadata' => [
                    'id' => $package->id,
                    'package' => $package->name,
                ],
            ]);

        return $response;

    }

    public function verify(string $reference)
    {
        $response = Http::withToken(config('services.paystack.secret_key'))
            ->get(config('services.paystack.base_url')."/transaction/verify/{$reference}");

        return $response;
    }
}
