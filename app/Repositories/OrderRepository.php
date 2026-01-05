<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Collection;

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

	/**
	 * fetchTodaysOrders function
	 *
	 * @return Collection
	 */
	public function fetchTodaysOrders() : Collection {
		return Order::with('items.product')->whereDate('created_at', now()->toDateString())->get();
	}

}