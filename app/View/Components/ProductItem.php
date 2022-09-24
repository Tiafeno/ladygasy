<?php

namespace App\View\Components;

use App\Models\ProductModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\View\Component;

class ProductItem extends Component
{
	public $product;
	public $default_attribute;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($productId)
    {
        try {
					$this->product = ProductModel::query()
							->where('id_product', '=', intval($productId))
							->first();
					if (!$this->product) {
						throw new ModelNotFoundException("Produit introuvable");
					}
					$this->default_attribute = (object)$this->product->getDefaultAttribute();
				} catch (ModelNotFoundException $e) {
					dd($e);
				}
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.product-item', [
						'product' => $this->product,
					'attribute' => $this->default_attribute
				]);
    }
}
