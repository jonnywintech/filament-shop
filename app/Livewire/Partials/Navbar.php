<?php

namespace App\Livewire\Partials;

use App\Helpers\CartManagment;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    public int $total_count = 0;
    public function mount(): void
    {
        $this->total_count = count(CartManagment::getCartItemsFromCookie());
    }
    #[On('update-cart-count')]
    public function updateCartCount(int $total_count): void
    {
        $this->total_count = $total_count;
    }
    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
