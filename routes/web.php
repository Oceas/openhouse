<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Public Property Search
Route::get('/search', [App\Http\Controllers\PublicSearchController::class, 'index'])->name('public.search');
Route::get('/search/map-properties', [App\Http\Controllers\PublicSearchController::class, 'getMapProperties'])->name('public.search.map-properties');

// Public property viewing route
Route::get('/p/{slug}', [App\Http\Controllers\PublicPropertyController::class, 'show'])->name('public.property.show');

// Public visitor sign-in routes
Route::get('/p/{slug}/signin', [App\Http\Controllers\VisitorSigninController::class, 'showSigninForm'])->name('public.property.signin.form');
Route::post('/p/{slug}/signin', [App\Http\Controllers\VisitorSigninController::class, 'store'])->name('public.property.signin');

// Stripe Webhook
Route::post('/stripe/webhook', [App\Http\Controllers\WebhookController::class, 'handleWebhook'])
    ->name('cashier.webhook')
    ->withoutMiddleware([\Laravel\Cashier\Http\Middleware\VerifyWebhookSignature::class]);

// Documentation routes
Route::get('/docs/getting-started', function () {
    return view('docs.getting-started');
})->name('docs.getting-started');

Route::get('/docs/property-management', function () {
    return view('docs.property-management');
})->name('docs.property-management');

Route::get('/docs/visitor-tracking', function () {
    return view('docs.visitor-tracking');
})->name('docs.visitor-tracking');

Route::get('/docs/subscriptions', function () {
    return view('docs.subscriptions');
})->name('docs.subscriptions');

Route::get('/docs/api', function () {
    return view('docs.api');
})->name('docs.api');

Route::get('/docs/faq', function () {
    return view('docs.faq');
})->name('docs.faq');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified', 'subscription'])->name('dashboard');

// Subscription routes (auth required but no subscription check)
Route::middleware('auth')->group(function () {
    Route::get('/subscription', [SubscriptionController::class, 'create'])->name('subscription.create');
    Route::post('/subscription/checkout', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::get('/subscription/success', [SubscriptionController::class, 'success'])->name('subscription.success');
    Route::get('/subscription/billing', [SubscriptionController::class, 'billing'])->name('subscription.billing');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    Route::post('/subscription/resume', [SubscriptionController::class, 'resume'])->name('subscription.resume');
});

Route::middleware(['auth', 'subscription'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Property Management Routes
    Route::resource('properties', PropertyController::class);
    Route::post('properties/{property}/remove-gallery-image', [PropertyController::class, 'removeGalleryImage'])->name('properties.remove-gallery-image');
    Route::get('properties/{property}/pdf', [PropertyController::class, 'generatePdf'])->name('properties.pdf');

    // Visitor Sign-in Management Routes
    Route::get('properties/{property}/visitors', [App\Http\Controllers\VisitorSigninController::class, 'index'])->name('properties.visitors.index');
    Route::get('properties/{property}/visitors/{visitorSignin}', [App\Http\Controllers\VisitorSigninController::class, 'show'])->name('properties.visitors.show');
    Route::get('properties/{property}/visitors/export', [App\Http\Controllers\VisitorSigninController::class, 'export'])->name('properties.visitors.export');

    // Test route for debugging
    Route::get('test-visitor/{property}/{visitorSignin}', function($propertyId, $visitorSigninId) {
        $property = App\Models\Property::find($propertyId);
        $visitorSignin = App\Models\VisitorSignin::find($visitorSigninId);
        return view('visitor-signins.show', compact('property', 'visitorSignin'));
    })->name('test.visitor.show');

    // Lead Management Routes
    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/follow-ups', [LeadController::class, 'followUps'])->name('leads.follow-ups');
    Route::get('/leads/export', [LeadController::class, 'export'])->name('leads.export');
    Route::get('/leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
    Route::patch('/leads/{lead}/status', [LeadController::class, 'updateStatus'])->name('leads.update-status');
    Route::post('/leads/{lead}/contact', [LeadController::class, 'markContacted'])->name('leads.mark-contacted');
    Route::post('/leads/{lead}/follow-up', [LeadController::class, 'scheduleFollowUp'])->name('leads.schedule-follow-up');
    Route::post('/leads/{lead}/notes', [LeadController::class, 'addNote'])->name('leads.add-note');

    // Analytics Routes
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/export', [AnalyticsController::class, 'export'])->name('analytics.export');

    // Team Management Routes
    Route::resource('teams', TeamController::class);
    Route::get('/teams/{team}/members', [TeamController::class, 'members'])->name('teams.members');
    Route::post('/teams/{team}/members', [TeamController::class, 'addMember'])->name('teams.add-member');
    Route::delete('/teams/{team}/members/{user}', [TeamController::class, 'removeMember'])->name('teams.remove-member');
});

require __DIR__.'/auth.php';
