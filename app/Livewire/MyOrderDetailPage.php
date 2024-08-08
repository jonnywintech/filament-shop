<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class MyOrderDetailPage extends Component
{
    public $order;

    public function mount($order)
    {
        $this->order = $order;
    }


    public function render()
    {
        $order_details = Order::with('address')->with('items')->find($this->order);
        return view('livewire.my-order-detail-page', compact('order_details'));
    }
}
