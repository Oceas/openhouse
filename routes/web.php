<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('home');

// Public property viewing route
Route::get('/p/{slug}', [App\Http\Controllers\PublicPropertyController::class, 'show'])->name('public.property.show');

// Public visitor sign-in routes
Route::get('/p/{slug}/signin', [App\Http\Controllers\VisitorSigninController::class, 'showSigninForm'])->name('public.property.signin.form');
Route::post('/p/{slug}/signin', [App\Http\Controllers\VisitorSigninController::class, 'store'])->name('public.property.signin');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
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
});

require __DIR__.'/auth.php';
