<?php

namespace App\Services;

use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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

	public function decreaseQuantities(Collection $cartItems): bool {
		
		DB::beginTransaction();

		try{
			
			foreach($cartItems as $item) {
				
				$product = $this->productRepository->getLockedRecord($item->product_id);
				
				if(!$product) {
					DB::rollBack();
					return false;
				}
				
				if ($product->stock_quantity < $item->quantity){
					DB::rollBack();
					return false;
				}

				$stock = $product->stock_quantity - $item->quantity;

				$this->productRepository->updateProductStock($product, $stock);
				
			}

			DB::commit();
			return true;

		}catch (\Throwable $e) {
			DB::rollBack();
			return false;
		}

	}


}
