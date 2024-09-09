<?php

use App\Http\Controllers\InvoicePdfController;
use App\Livewire\Blog;
use App\Livewire\Post;
use App\Livewire\CartPage;
use App\Livewire\HomePage;
use App\Livewire\ContactUs;
use App\Livewire\MyAccount;
use App\Livewire\CancelPage;
use App\Livewire\Auth\Logout;
use App\Livewire\SuccessPage;
use App\Livewire\CheckoutPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\ProductsPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\CategoriesPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\ProductDetailPage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\Auth\ForgotPasswordPage;

Route::get('/', HomePage::class)->name('home');
Route::get('/categories', CategoriesPage::class);
Route::get('/category/{slug}', CategoriesPage::class);
Route::get('/products', ProductsPage::class);
Route::get('/cart', CartPage::class);
Route::get('/products/{slug}', ProductDetailPage::class)->name('product.page');
Route::get('/contact', ContactUs::class);
Route::get('/blog', Blog::class);
Route::get('/blog/{slug}', Post::class);

Route::get('/generate-pdf/{order}', InvoicePdfController::class)->name('generate.pdf');

Route::middleware('guest')->group(function () {
    Route::get('/register', RegisterPage::class)->name('register');
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/forgot-password', ForgotPasswordPage::class)->name('password.request');
    Route::get('/reset-password/{token}', ResetPasswordPage::class)->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout', CheckoutPage::class);
    Route::get('/my-orders', MyOrdersPage::class);
    Route::get('/my-orders/{order}', MyOrderDetailPage::class)->name('my-orders.show');
    Route::get('/my-account', MyAccount::class);
    Route::get('/success', SuccessPage::class)->name('success');
    Route::get('/cancel', CancelPage::class)->name('cancel');
    Route::post('/logout', Logout::class);
});
