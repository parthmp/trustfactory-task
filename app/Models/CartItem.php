<?php

namespace App\Models;

use Brick\Math\BigDecimal;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_items';

	protected $appends = ['line_total'];

	public function product(){
		return $this->belongsTo(Product::class, 'product_id');
	}

	/**
	 * getLineTotalAttribute function
	 *
	 * @return string
	 */
	public function getLineTotalAttribute() : string {

        if(!$this->product || !$this->product->price){
            return '0.00';
        }
        
        $quantity = BigDecimal::of($this->quantity);
        $price = BigDecimal::of($this->product->price);
        
        return (string) $quantity->multipliedBy($price);

    }

	/**
	 * scopeWithTotals function
	 *
	 * @param [type] $query
	 * @param [type] $userId
	 * @return array
	 */
	public function scopeWithTotals($query, $userId, $withTrashed = false) : array {

		if($withTrashed){
			
			$cartItems = CartItem::where('user_id', $userId)->with(['product' => function($query) { 
				$query->withTrashed();
			}])->get();

		}else{
			$cartItems = $query->where('user_id', $userId)->with('product')->get();
		}
        
        
        $grandTotal = BigDecimal::of(0);
        $totalItems = 0;
        $totalQuantity = 0;
        
        foreach($cartItems as $item) {
            $grandTotal = $grandTotal->plus(BigDecimal::of($item->line_total));
            $totalItems++;
            $totalQuantity += $item->quantity;
        }
        
        return [
            'items' => $cartItems,
            'summary' => [
                'grand_total' => (string) $grandTotal,
                'grand_total_formatted' => '$' . number_format((float) (string) $grandTotal, 2),
                'total_items' => $totalItems,
                'total_quantity' => $totalQuantity,
            ]
        ];
    }

}
