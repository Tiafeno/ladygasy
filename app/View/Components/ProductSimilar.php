<?php

namespace App\View\Components;

use App\Models\ProductModel;
use Illuminate\View\Component;

class ProductSimilar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(ProductModel $product)
    {
        $categories = $product->getCategories();
        if (!empty($categories)) {

        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.product-similar');
    }
}
