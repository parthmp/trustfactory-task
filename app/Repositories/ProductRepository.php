<?php

namespace App\Repositories;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository {

	/**
	 * fetchAll function
	 *
	 * @return Collection|null
	 */
	public function fetchAll() : Collection|null {

		return Product::orderBy('product_name', 'asc')->get();

	}

	public function fetchStockForCartValidation(Collection $items){
		return Product::whereIn('id', collect($items)->pluck('product_id'))->get()->keyBy('id');
	}

	/**
	 * fetchById function
	 *
	 * @param integer $productId
	 * @return Product|null
	 */
	public function fetchById(int $productId) : Product|null {
		return Product::where('id', '=', $productId)->first();
	}

	/**
	 * getLockedRecords function
	 *
	 * @param integer $productId
	 * @return Product|null
	 */
	public function getLockedRecord(int $productId) : Product|null {
		return Product::where('id', '=', $productId)->lockForUpdate()->first();
	}

	/**
	 * updateProductStock function
	 *
	 * @param Product $product
	 * @param [type] $stock
	 * @return boolean
	 */
	public function updateProductStock(Product $product, $stock) : bool {
		$product->stock_quantity = $stock;
		return $product->save();
	}

}
