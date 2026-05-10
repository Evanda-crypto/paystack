<?php

use Livewire\Component;
use App\Models\Subscription;
use Livewire\Attributes\Computed;

new class extends Component
{
    // public $subscriptions = [];

    public function mount()
    {
        // $this->subscriptions = Subscription::all();
    }

    #[Computed]
    public function subscriptions()
    {
        return Subscription::latest()->paginate(10);
    }
};
?>

<div>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-8 px-4">

    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

    {{-- Heading --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            My Subscriptions
        </h1>

        <p class="mt-2 text-gray-600 dark:text-gray-400">
            View all your active and previous subscriptions
        </p>
    </div>

    {{-- Search --}}
    <div class="flex items-center gap-3">

        {{-- Search Input --}}
        <div class="relative">
            <input
                type="text"
                name="search"
                placeholder="Search subscriptions..."
                class="w-72 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-3 pl-10 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:border-gray-900 dark:focus:border-white focus:ring-0"
            >

            {{-- Search Icon --}}
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5 absolute left-3 top-3.5 text-gray-400"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        {{-- Filter --}}
        <select
            class="rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-3 text-sm text-gray-900 dark:text-white focus:border-gray-900 dark:focus:border-white focus:ring-0"
        >
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="expired">Expired</option>
            <option value="pending">Pending</option>
        </select>

    </div>
</div>

        {{-- Table Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-sm text-left">

                    {{-- Table Head --}}
                    <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-200">
                                User
                            </th>
                            <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-200">
                                Package
                            </th>

                            <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-200">
                                Amount
                            </th>

                            <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-200">
                                Start Date
                            </th>

                            <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-200">
                                Expiry Date
                            </th>

                            <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-200">
                                Status
                            </th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                        @forelse($this->subscriptions as $subscription)

                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">

                                {{-- Package --}}
                                  {{-- Package --}}
                                <th class="px-6 py-4">
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        {{ $subscription->user->name }}
                                    </div>
                                </th>

                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        {{ $subscription->package->name }}
                                    </div>
                                </td>

                                {{-- Amount --}}
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                    KES {{ number_format($subscription->amount) }}
                                </td>

                                {{-- Start Date --}}
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                    {{ \Carbon\Carbon::parse($subscription->created_at)->format('d M Y H:i') }}
                                </td>

                                {{-- Expiry Date --}}
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                    {{ \Carbon\Carbon::parse($subscription->end_date)->format('d M Y') }}
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4">

                                    @if($subscription->status == 'success')
                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                            Success
                                        </span>
                                    @elseif($subscription->status == 'expired')
                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                            Expired
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                                            Pending
                                        </span>
                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                    No subscriptions found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                    
                </table>

            </div>
<div class="m-6">
    {{ $this->subscriptions->links() }}
</div>
            
        </div>

    </div>

</div>
</div>