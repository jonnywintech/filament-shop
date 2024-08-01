<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Products - Shopmania')]
class ProductsPage extends Component
{
    use WithPagination;
    public function render()
    {
        $productQuery = Product::query()->where('is_active', 1);

        return view(
            'livewire.products-page',
            [
                'products' => $productQuery->paginate(1),
                'brands' => Brand::where('is_active', 1)->get(['id', 'name', 'slug']),
                'categories' => Category::where('is_active', 1)->get(['id', 'name', 'slug']),
            ]
        );
    }
}
