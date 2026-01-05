<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderItem;

/**
 * OrderRepository class
 */
class OrderRepository {

	/**
	 * createOrder function
	 *
	 * @param integer $userId
	 * @param float $total
	 * @return Order
	 */
	public function createOrder(int $userId, float $total) : Order {
		$order = new Order();
		$order->order_number = uniqid(rand());
		$order->user_id = $userId;
		$order->order_total = $total;
		$order->save();
		return $order;
	}

	public function addOrderItems(array $items){
		OrderItem::insert($items);
	}

}