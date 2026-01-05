<?php

namespace App\Services;

use App\Models\CartItem;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;

class OrderService {

	public function __construct(private OrderRepository $orderRepository, private ProductRepository $productRepository){}

	public function validateStockOnCheckout(Collection $items) :array {

		$products = $this->productRepository->fetchStockForCartValidation($items);

		$errors = [];

		foreach ($items as $item) {

			$product = $products->get($item['product_id']);
			
			if(!$product){
				$errors[] = "One of the products is no longer available.";
				continue;
			}

			
			if($item['quantity'] > $product->stock_quantity){
				$errors[] = sprintf('%s has only %d item(s) left in stock.',
					$product->product_name,
					$product->stock_quantity
				);
			}
		}

		return $errors;
	}

	public function createOrder(array $data){

		$items = $data['items'];
		$summary = $data['summary'];

		$order = $this->orderRepository->createOrder(auth()->id(), $summary['grand_total']);

		$insert = [];

		foreach($items as $item){

			$temp = [];

			$temp['order_id'] = $order->id;
			$temp['user_id'] = auth()->id();
			$temp['product_id'] = $item->product_id;
			$temp['quantity'] = $item->quantity;
			$temp['line_total'] = $item->line_total;
			
			$insert[] = $temp;

		}

		$this->orderRepository->addOrderItems($insert);


	}

}