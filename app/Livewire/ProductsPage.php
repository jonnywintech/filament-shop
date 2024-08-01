<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Products - Shopmania')]
class ProductsPage extends Component
{
    use WithPagination;

    #[Url]
    public array $selected_categories = [];
    #[Url]

    public array $selected_brands = [];
    #[Url]
    public string $featured;
    #[Url]
    public string $on_sale;

    public string $price_range = '900';
    public function render()
    {
        $productQuery = Product::query()->where('is_active', 1);

        if(!empty($this->selected_categories)){
            $productQuery = $productQuery->whereIn('category_id', $this->selected_categories);
        }

        if(!empty($this->selected_brands)){
            $productQuery = $productQuery->whereIn('brand_id', $this->selected_brands);
        }
        if(!empty($this->featured)){
            $productQuery = $productQuery->where('is_featured', 1);
        }
        if(!empty($this->on_sale)){
            $productQuery = $productQuery->where('on_sale', 1);
        }
        if(!empty($this->price_range)){
            $productQuery = $productQuery->where('price', '>=', $this->price_range);
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
