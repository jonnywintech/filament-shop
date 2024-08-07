<?php

namespace App\Livewire;

use App\Helpers\CartManagment;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Checkout')]
class CheckoutPage extends Component
{

    public string
        $first_name,
        $last_name,
        $phone,
        $address,
        $city,
        $state,
        $zip,
        $payment_method;

    public function checkout()
    {
       $this->validate([
        'first_name' => 'required|string|min:3|max:255',
        'last_name' => 'required|string|min:3|max:255',
        'phone' => 'required|numeric',
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
        'zip' => 'required',
        'payment_method' => 'required'
       ]);

       $cart_items = CartManagment::getCartItemsFromCookie();
    }
    public function render()
    {
        $cart_items = CartManagment::getCartItemsFromCookie();
        $grand_total = CartManagment::calculateGrandTotal($cart_items);
        return view('livewire.checkout-page', compact('cart_items', 'grand_total'));
    }
}
