<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class MyOrdersPage extends Component
{
    public function render()
    {
        $orders = Order::where('user_id', auth()->user()->id)->orderBy('created_at','desc')->paginate(10);

        return view('livewire.my-orders-page', compact('orders'));
    }
}
