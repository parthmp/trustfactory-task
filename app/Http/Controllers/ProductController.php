<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Fortify\Features;

class ProductController extends Controller {

	public function __construct(private ProductService $productService) {}

    public function index(){

		
		$error = '';

		try{
			$products = $this->productService->fetchAll();
		}catch(Exception $e){
			$products = [];
			$error = 'Unable to fetch products, try again later.';
		}


		return Inertia::render('Home', [
				'canRegister'		=> 	Features::enabled(Features::registration()),
				'products'			=>	$products,
				'currencySymbol'	=> 	config('constants.currency_symbol'),
				'error'				=>	$error,
				'cartItemsNumber'	=>	$this->productService->fetchCartItemsNumber((int) auth()->id())
			]);
		

	}
}
