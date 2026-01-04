<?php

namespace App\Services;

use App\Repositories\CartRepository;

class CartService {

	public function __construct(private CartRepository $cartRepository){}

	/**
	 * store function
	 *
	 * @param array $data
	 * @return boolean
	 */
	public function store(array $data) : bool {

		return $this->cartRepository->addToCart(auth()->id(), $data['productId'], $data['quantity']);

	}

}