<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddToCartRequest;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller {

	public function __construct(private CartService $cartService){}

    public function store(AddToCartRequest $request){

		$this->cartService->store($request->validated());
		return redirect()->back()->with('success', 'Item added to cart');;

	}
}
