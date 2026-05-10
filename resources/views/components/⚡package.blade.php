<?php

use Livewire\Component;
use App\Models\Package;
use App\Models\Subscription;

new class extends Component {
    public $packages = [];

    public $user;

    public function mount()
    {
        $this->user = auth()->user();
        $this->packages = App\Models\Package::all();
    }


    public function purchasePackage($packageId)
    {
        $package = Package::findOrFail($packageId);

        $subscription = Subscription::create([
            'package_id' => $package->id,
            'amount' => $package->price,
            'user_id' => $this->user->id
        ]);

        $this->dispatch('paystack-pay', [

            'key' => config('services.paystack.public_key'),

            'email' => $this->user->email,

            'currency' => 'KES',

            'amount' => $package->price *100,

            'package_id' => $package->id,

            'package_name' => $package->name,

            'subscription_id' => $subscription->id
        ]);
    }

};
?>

<div>
    {{-- Walk as if you are kissing the Earth with your feet. - Thich Nhat Hanh --}}

    <div class="min-h-screen bg-zinc-100 dark:bg-zinc-900 py-12 px-4">

        <div class="max-w-7xl mx-auto">

            {{-- Heading --}}
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-zinc-900 dark:text-white">
                    Packages
                </h1>

                <p class="mt-3 text-zinc-600 dark:text-zinc-400">
                    Choose a package that works best for you
                </p>
            </div>

            {{-- Cards --}}
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @foreach($packages as $package)

                    <div
                        class="bg-white dark:bg-zinc-800 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6 flex flex-col hover:shadow-md transition">

                        {{-- Package Name --}}
                        <h2 class="text-2xl font-semibold text-zinc-900 dark:text-white mb-4">
                            {{ $package->name }}
                        </h2>

                        {{-- Price --}}
                        <div class="mb-4">
                            <span class="text-3xl font-bold text-zinc-900 dark:text-white">
                                KES {{ number_format($package->price) }}
                            </span>
                        </div>

                        {{-- Description --}}
                        <p class="text-zinc-600 dark:text-zinc-400 mb-6 flex-grow">
                            {{ $package->description }}
                        </p>

                        {{-- Button --}}
                        <flux:button variant="primary" wire:click="purchasePackage(`{{ $package->id }}`)">
                            Purchase
                        </flux:button>

                    </div>

                @endforeach

            </div>

        </div>
    </div>

    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script>

        document.addEventListener('livewire:init', () => {

            Livewire.on('paystack-pay', (data) => {

                const payload = data[0];

                let handler = PaystackPop.setup({

                    key: payload.key,

                    email: payload.email,

                    currency: payload.currency,

                    amount: payload.amount,

                    metadata: {
                        package_id: payload.package_id,
                        package_name: payload.package_name,
                        subscription_id:payload.subscription_id,
                    },

                    callback: function (response) {

                        window.location.href = "/payments/" + response.reference;
                    },

                    onClose: function () {

                        console.log('Payment closed');
                    }
                });

                handler.openIframe();
            });
        });
    </script>
</div>