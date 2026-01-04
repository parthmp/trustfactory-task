<?php

namespace App\Repositories;

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

}
