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
        $this->order_id = request()->query('order_id') ?? 0;

        if ($this->order_id === 0) {
            session()->flash('error', 'Error while getting order_id');
            return redirect()->route('home');
        }
    }
    public function render()
    {
        $order = Order::with('address')->find($this->order_id);

        return view('livewire.success-page', compact('order'));
    }
}
