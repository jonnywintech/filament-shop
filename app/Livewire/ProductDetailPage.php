<?php

namespace App\Livewire;

use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Helpers\CartManagment;
use Livewire\Attributes\Title;
use App\Livewire\Partials\Navbar;

#[Title('Product Detail - Shopmania')]
class ProductDetailPage extends Component
{
    use LivewireAlert;
    public string $slug;

    public int $quantity = 1;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
    }

    public function increaseQty(): void
    {
        $this->quantity++;
    }
    public function decreaseQty(): void
    {
        if ($this->quantity <= 1) {
            return;
        }
        $this->quantity--;
    }

    public function addToCart(int $id): void
    {
        $total_count = CartManagment::addItemsToCartWithQty($id, $this->quantity);

        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

        $this->alert('success', 'Product added to the cart successfully!', [
        'position' => 'bottom-end',
        'timer' => 1000,
        'toast' => true,
        ]);
    }

    public function render()
    {


        return view('livewire.product-detail-page', [
            'product' => Product::where('slug', $this->slug)->firstOrFail(),
        ]);
    }
}
