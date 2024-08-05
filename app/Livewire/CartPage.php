<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helpers\CartManagment;
use App\Livewire\Partials\Navbar;

class CartPage extends Component
{

    public array $cart_items = [];
    public int|float $grand_total = 0;

    public function mount(): void
    {
        $this->cart_items = CartManagment::getCartItemsFromCookie();
        $this->grand_total = CartManagment::calculateGrandTotal($this->cart_items);
    }

    public function removeCartItem(int $id): void
    {
        $this->cart_items = CartManagment::removeCartItem($id);
        $this->grand_total = CartManagment::calculateGrandTotal($this->cart_items);
        $this->dispatch('update-cart-count', total_count: array_sum(array_column($this->cart_items, 'quantity')))->to(Navbar::class);
    }

    public function addQuantity(int $id): void
    {
        $this->cart_items = CartManagment::incrementQuantityToCartItem($id);
        $this->grand_total = CartManagment::calculateGrandTotal($this->cart_items);
        $this->dispatch('update-cart-count', total_count: array_sum(array_column($this->cart_items, 'quantity')))->to(Navbar::class);
    }
    public function deductQuantity(int $id): void
    {
        $this->cart_items = CartManagment::decrementQuantityToCartItem($id);
        $this->grand_total = CartManagment::calculateGrandTotal($this->cart_items);
        $this->dispatch('update-cart-count', total_count: array_sum(array_column($this->cart_items, 'quantity')))->to(Navbar::class);
    }
    public function render()
    {
        return view('livewire.cart-page');
    }
}
