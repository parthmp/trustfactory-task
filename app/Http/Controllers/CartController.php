<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\ModifyCartRequest;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Fortify\Features;

class CartController extends Controller {

	public function __construct(private CartService $cartService, private ProductService $productService, private OrderService $orderService){}

	public function store(ModifyCartRequest $request){

		$data = $request->validated();
		
		$modifiedQuantity = $this->cartService->modifyQuantity(auth()->id(), $data['productId'], $data['operation']);

		if($modifiedQuantity === false){
			return redirect()->back()->with('error', 'We do not have more quantity of this item');
		}

		return redirect()->back()->with('success', 'Cart updated successfully');
	}

	public function show(Request $request){

		$cartItems = $this->cartService->fetchCartById((int) auth()->id());

		return Inertia::render('Cart', [
				'canRegister'		=> 	Features::enabled(Features::registration()),
				'currencySymbol'	=> 	config('constants.currency_symbol'),
				'error'				=>	'',
				'cartItems'			=>	$cartItems,
				'cartItemsNumber'	=>	$this->productService->fetchCartItemsNumber((int) auth()->id())
			]);

	}

	public function checkout(Request $request){
		
		$cartItems = $this->cartService->fetchCartById((int) auth()->id());
		
		$errors = $this->orderService->validateStockOnCheckout($cartItems['items']);

		if(!empty($errors)){
			return redirect()->back()->with('error', implode(' ', $errors));
		}

		$this->orderService->createOrder($cartItems);
		$this->cartService->makeItEmpty((int) auth()->id());
		$this->productService->decreaseQuantities($cartItems['items']);

		return redirect('/')->with('success', 'Order created successfully');

	}

}
