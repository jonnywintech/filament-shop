<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Session\Session;

class SuccessPage extends Component
{

    public ?int $order_id;

    public function mount()
    {
        $this->order_id = 24;

        // session()->forget('order_id');
    }
    public function render()
    {
        $order = Order::with('address')->find($this->order_id);

        return view('livewire.success-page', compact('order'));
    }
}
