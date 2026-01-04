<?php

namespace App\Repositories;

use App\Models\CartItem;

/**
 * CartRepository class
 */
class CartRepository {
	
	/**
	 * cartQuntityByUserId function
	 *
	 * @param integer $userId
	 * @return integer
	 */
	public function getCartItemsByUserId(int $userId) : int {
		return (int) CartItem::where('user_id', '=', $userId)->count();
	}

	/**
	 * fetchCartItemsByProductId function
	 *
	 * @param integer $productId
	 * @return CartItem|null
	 */
	public function fetchCartItemsByProductAndUserId(int $userId, int $productId) : CartItem|null {
		return CartItem::where([['user_id', '=', $userId], ['product_id', '=', $productId]])->first();
	}

	/**
	 * createNewCartItem function
	 *
	 * @param integer $userId
	 * @param integer $productId
	 * @return boolean
	 */
	public function createNewCartItem(int $userId, int $productId) : bool {

		$cartItem = new CartItem();
		$cartItem->user_id = $userId;
		$cartItem->product_id = $productId;
		$cartItem->quantity = 1;

		return $cartItem->save();

	}

	/**
	 * updateCartItem function
	 *
	 * @param CartItem $cartItem
	 * @param integer $quantity
	 * @return boolean
	 */
	public function updateCartItem(CartItem $cartItem, int $quantity) : bool {
		$cartItem->quantity = $quantity;
		return $cartItem->save();
	}

	/**
	 * addToCart function
	 *
	 * @param integer $userId
	 * @param integer $productId
	 * @param integer $quantity
	 * @return boolean
	 */
	public function addToCart(int $userId, int $productId, int $quantity) : bool {

		$cartItem = $this->fetchCartItemsByProductAndUserId($userId, $productId);

		if(!$cartItem){
			return $this->createNewCartItem($userId, $productId);
		}

		return $this->updateCartItem($cartItem, $quantity);
	}

}