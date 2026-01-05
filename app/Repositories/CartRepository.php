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
		return (int) CartItem::where('user_id', '=', $userId)->sum('quantity');
	}

	/**
	 * fetchCartItemsByProductId function
	 *
	 * @param integer $productId
	 * @return CartItem|null
	 */
	public function fetchCartItemByProductAndUserId(int $userId, int $productId) : CartItem|null {
		return CartItem::where([['user_id', '=', $userId], ['product_id', '=', $productId]])->first();
	}

	/**
	 * createNewCartItem function
	 *
	 * @param integer $userId
	 * @param integer $productId
	 * @return CartItem
	 */
	public function firstOrCreateCartItem(int $userId, int $productId) : CartItem {
		
		$cartItem = CartItem::where([['user_id', '=', $userId], ['product_id', '=', $productId]])->first();
    
		if(!$cartItem){
			$cartItem = new CartItem();
			$cartItem->user_id = $userId;
			$cartItem->product_id = $productId;
			$cartItem->quantity = 0;
			$cartItem->save();
		}
		
		return $cartItem;

	}

	/**
	 * updateCartItem function
	 *
	 * @param CartItem $cartItem
	 * @param integer $quantity
	 * @return CartItem
	 */
	public function updateCartItem(CartItem $cartItem, int $quantity) : CartItem {
		$cartItem->quantity = $quantity;
		$cartItem->save();
		return $cartItem;
	}

	public function removeCartItem(CartItem $cartItem){
		$cartItem->delete();
	}

	/**
	 * makeItEmpty function
	 *
	 * @param integer $userId
	 * @return void
	 */
	public function makeItEmpty(int $userId){
		CartItem::where('user_id', '=', $userId)->delete();
	}

}