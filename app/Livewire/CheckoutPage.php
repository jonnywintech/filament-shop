<?php

namespace App\Livewire;

use Stripe\Stripe;
use App\Models\Order;
use App\Models\Address;
use Livewire\Component;
use Stripe\Checkout\Session;
use App\Helpers\CartManagment;
use Livewire\Attributes\Title;
use App\Mail\Order as MailOrder;
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

        $line_items = [];

        foreach ($cart_items as $item) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $item['unit_amount'] * 100, // assuming unit_amount is in dollars
                    'product_data' => [
                        'name' => $item['name']
                    ],
                ],
                'quantity' => $item['quantity'],
            ];
        }

        // Ensure there are line items before proceeding
        if (empty($line_items)) {
            throw new \Exception('No items in cart');
        }

        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->grand_total = CartManagment::calculateGrandTotal($cart_items);
        $order->payment_method = $this->payment_method;
        $order->payment_status = 'pending';
        $order->status = 'new';
        $order->currency = 'USD';
        $order->notes = "Order created by " . auth()->user()->name;
        // $order->shipping_amount = 0;
        // $order->shipping_method = 'none';

        $address = new Address();
        $address->first_name = $this->first_name;
        $address->last_name = $this->last_name;
        $address->phone = $this->phone;
        $address->street_address = $this->address;
        $address->city = $this->city;
        $address->state = $this->state;
        $address->zip_code = $this->zip;

        $redirect_url = '';
        $order->save();

        $address->order_id = $order->id;
        $address->save();

        foreach ($cart_items as &$item) {
            unset($item['name']);
            unset($item['image']);
            $item['order_id'] = $order->id;
        }

        if ($this->payment_method == 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session_checkout = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => auth()->user()->email,
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => route('success') . '?order_id=' . $order->id,
                'cancel_url' => route('cancel'),
            ]);
            $redirect_url = $session_checkout->url;
        } else {
            $redirect_url = route('success') . '?order_id=' . $order->id;
        }



        $order->items()->createMany($cart_items);
        Mail::to(request()->user())->send(new MailOrder($order));
        CartManagment::clearCartItems();

        return redirect($redirect_url);
    }
    public function render()
    {
        $cart_items = CartManagment::getCartItemsFromCookie();
        $grand_total = CartManagment::calculateGrandTotal($cart_items);
        return view('livewire.checkout-page', compact('cart_items', 'grand_total'));
    }
}
