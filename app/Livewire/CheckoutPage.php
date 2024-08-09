<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Address;
use Livewire\Component;
use App\Helpers\CartManagment;
use App\Mail\Order as MailOrder;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Mail;

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

    public function mount()
    {
        $cart_items = CartManagment::getCartItemsFromCookie();
        if (count($cart_items) === 0) {
            return redirect('/products');
        }
    }
    public function checkout()
    {
        $this->validate([
            'first_name' => 'required|string|min:3|max:255',
            'last_name' => 'required|string|min:3|max:255',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'payment_method' => 'required'
        ]);

        $cart_items = CartManagment::getCartItemsFromCookie();
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->grand_total = CartManagment::calculateGrandTotal($cart_items);
        $order->payment_method = $this->payment_method;
        $order->payment_status = 'pending';
        $order->status = 'new';
        $order->currency = 'USD';
        $order->notes = "Order created by " . auth()->user()->name;

        $address = new Address();
        $address->first_name = $this->first_name;
        $address->last_name = $this->last_name;
        $address->phone = $this->phone;
        $address->street_address = $this->address;
        $address->city = $this->city;
        $address->state = $this->state;
        $address->zip_code = $this->zip;

        $order->save();

        $address->order_id = $order->id;
        $address->save();

        foreach ($cart_items as &$item) {
            unset($item['name']);
            unset($item['image']);
            $item['order_id'] = $order->id;
        }

        $order->items()->createMany($cart_items);
        Mail::to(request()->user())->send(new MailOrder($order));
        CartManagment::clearCartItems();

        return redirect('/success?order_id=' . $order->id);
    }
    public function render()
    {
        $cart_items = CartManagment::getCartItemsFromCookie();
        $grand_total = CartManagment::calculateGrandTotal($cart_items);
        return view('livewire.checkout-page', compact('cart_items', 'grand_total'));
    }
}
