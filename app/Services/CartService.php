<?php

namespace App\Services;

use App\Models\CartItem;
use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;

class CartService {

	public function __construct(private CartRepository $cartRepository, private ProductRepository $productRepository){}

	/**
	 * modifyQuantity function
	 *
	 * @param integer $userId
	 * @param integer $productId
	 * @param string $operation
	 * @return integer|false
	 */
	public function modifyQuantity(int $userId, int $productId, string $operation): int|false {
		
		$cartItem = $this->cartRepository->firstOrCreateCartItem($userId, $productId);

		if($operation === 'add'){
			
			if($cartItem->quantity >= $cartItem->product->stock_quantity){
				return false;
			}

			$cartItem->quantity++;

		}else if($operation === 'sub'){
			
			if($cartItem->quantity > 1){

				$cartItem->quantity--;

			}else{

				$this->cartRepository->removeCartItem($cartItem);
				return 0;

			}

		}

		$cartItem = $this->cartRepository->updateCartItem($cartItem, $cartItem->quantity);

		return $cartItem->quantity;

	}

	

	/**
	 * checkifItemIsAvailableToAdd function
	 *
	 * @param integer $userId
	 * @param integer $productId
	 * @param integer $incremented
	 * @return boolean
	 */
	public function checkifItemIsAvailableToAdd(int $userId, int $productId, int $incremented) : bool {

		$product = $this->productRepository->fetchById($productId);

		if((int) $product->stock_quantity > $incremented){
			return true;
		}

		return false;

	}

	/**
	 * fetchCart function
	 *
	 * @param integer $userId
	 * @return array
	 */
	public function fetchCartById(int $userId) : array {

		return CartItem::withTotals($userId);

	}

	/**
	 * makeItEmpty function
	 *
	 * @param integer $userId
	 * @return void
	 */
	public function makeItEmpty(int $userId){
		$this->cartRepository->makeItEmpty($userId);
	}

}