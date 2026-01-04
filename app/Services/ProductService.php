<?php

namespace App\Services;

use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;

class ProductService {

	public function __construct(private ProductRepository $productRepository, private CartRepository $cartRepository){}

	/**
	 * fetchAll function
	 *
	 * @return Collection|null
	 */
	public function fetchAll() : Collection|null {
		return $this->productRepository->fetchAll();
	}

	/**
	 * fetchCartItemsNumber function
	 *
	 * @param integer $userId
	 * @return integer
	 */
	public function fetchCartItemsNumber(int $userId) : int {
		return $this->cartRepository->getCartItemsByUserId($userId);
	}

}
