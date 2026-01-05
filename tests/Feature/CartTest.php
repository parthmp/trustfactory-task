<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartTest extends TestCase
{
	use RefreshDatabase;
	
   	public function test_add_operation_respects_stock(){
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock_quantity' => 5]);

        $cartService = app(CartService::class);

        // Add 5 times
        for ($i = 1; $i <= 5; $i++) {
            $quantity = $cartService->modifyQuantity($user->id, $product->id, 'add');
            $this->assertEquals($i, $quantity);
        }

        // Adding 6th time should fail
        $this->assertFalse($cartService->modifyQuantity($user->id, $product->id, 'add'));
    }

    public function test_sub_operation_decrements_or_removes_item(){
		
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock_quantity' => 10]);

        $cartService = app(CartService::class);

        // Start by adding 2
        $cartService->modifyQuantity($user->id, $product->id, 'add');
        $cartService->modifyQuantity($user->id, $product->id, 'add');

        // Subtract once -> quantity should be 1
        $this->assertEquals(1, $cartService->modifyQuantity($user->id, $product->id, 'sub'));

        // Subtract again -> should remove item, return 0
        $this->assertEquals(0, $cartService->modifyQuantity($user->id, $product->id, 'sub'));

    }
}
