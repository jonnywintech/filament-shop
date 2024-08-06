<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Helpers\Cartmanagment;
use Livewire\Attributes\Title;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('Products - Shopmania')]
class ProductsPage extends Component
{
    use WithPagination, LivewireAlert;

    #[Url]
    public array $selected_categories = [];
    #[Url]

    public array $selected_brands = [];
    #[Url]
    public string $featured;
    #[Url]
    public string $on_sale;

    public string $price_range = '900';

    public string $sort = '';

    public function addToCart(string $id): void
    {
        $total_count =   CartManagment::addItemsToCart($id);

        $this->alert('success', 'Product added to the cart successfully!', [
            'position' => 'bottom-end',
            'timer' => '1000',
            'toast' => true,
        ]);

        $this->dispatch('update-cart-count', total_count: array_sum(array_column($total_count,'quantity')))->to(Navbar::class);
    }
    public function render()
    {
        $productQuery = Product::query()->where('is_active', 1);

        if (!empty($this->selected_categories)) {
            $productQuery = $productQuery->whereIn('category_id', $this->selected_categories);
        }

        if (!empty($this->selected_brands)) {
            $productQuery = $productQuery->whereIn('brand_id', $this->selected_brands);
        }

        if (!empty($this->featured)) {
            $productQuery = $productQuery->where('is_featured', 1);
        }

        if (!empty($this->on_sale)) {
            $productQuery = $productQuery->where('on_sale', 1);
        }

        if (!empty($this->price_range)) {
            $productQuery = $productQuery->where('price', '>=', $this->price_range);
        }

        if (!empty($this->sort)) {
            match ($this->sort) {
                'price' => $productQuery = $productQuery->orderBy('price', 'ASC'),
                'latest' => $productQuery = $productQuery->orderBy('created_at', 'DESC'),
            };
        }

        return view(
            'livewire.products-page',
            [
                'products' => $productQuery->paginate(10),
                'brands' => Brand::where('is_active', 1)->get(['id', 'name', 'slug']),
                'categories' => Category::where('is_active', 1)->get(['id', 'name', 'slug']),
                'sel_categories' => Category::whereIn('id', $this->selected_categories)->get('name')->pluck('name')->toArray(),
            ]
        );
    }
}
