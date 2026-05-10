<?php

use App\Http\Controllers\API\PayStackController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Middleware\EnsureTeamMembership;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::view('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class])
    ->group(function () {
        Route::view('dashboard', 'dashboard')->name('dashboard');
    });

Route::middleware(['auth'])->group(function () {
    Route::livewire('invitations/{invitation}/accept', 'pages::teams.accept-invitation')->name('invitations.accept');
    Route::livewire('packages','package')->name('packages.index');
    Route::livewire('subscriptions','subscriptions')->name('subscriptions.index');
});

// Route::resource('subscrptions',SubscriptionsController::class);
Route::get('payments/{reference}',[PayStackController::class,'callback']);

Route::get('/wifi/payment/callback', function (\Illuminate\Http\Request $request) {

    $reference = $request->reference;

    $response = Http::withToken(config('services.paystack.secret_key'))
        ->get("https://api.paystack.co/transaction/verify/{$reference}");

    $data = $response->json();

    if (
        $data['status']
        && $data['data']['status'] === 'success'
    ) {

        $metadata = $data['data']['metadata'];

        $packageId = $metadata['package_id'];

        // Activate internet here

        return redirect('/success');
    }

    return redirect('/failed');

})->name('wifi.callback');

require __DIR__.'/settings.php';
