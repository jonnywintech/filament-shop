<?php

namespace App\Livewire;

use Livewire\Component;

class OrderStatus extends Component
{
    public string $status;
    public string $color;

    public function mount($status)
    {
        $this->status = $status;
        $this->color = match ($status) {
            'new' => 'bg-blue-500',
            'processing' => 'bg-yellow-500',
            'shipped' => 'bg-blue-500',
            'delivered' => 'bg-green-500',
            'canceled' => 'bg-red-500',
            default => 'bg-green-500',
        };
    }
    public function render()
    {
        return view('livewire.order-status', [
            'status' => $this->status,
            'color' => $this->color,
        ]);
    }
}
