<?php

namespace App\Livewire;

use Livewire\Component;

class PaymentStatus extends Component
{
    public string $status;
    public string $color;

    public function mount($status)
    {

        $this->status = $status;

        $this->color = match ($status) {
            'pending' => 'bg-yellow-500',
            'paid' => 'bg-green-500',
            'failed' => 'bg-red-500',
        };
    }
    public function render()
    {
        return view('livewire.payment-status');
    }
}
