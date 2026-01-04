<?php

namespace App\Http\Requests\Cart;

use App\Helpers\Sanitize;
use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

	/**
	 * prepareForValidation function
	 *
	 * @return void
	 */
	protected function prepareForValidation()
	{

		$productId = Sanitize::input($this->input('productId'));
		$quantity = Sanitize::input($this->input('quantity'));

		$this->merge([
			'productId'		=>	$productId,
			'quantity'		=>	$quantity
		]);
	}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'productId' 	=> ['required', 'exists:products,id'],
            'quantity' 		=> ['required', 'integer', 'min:1'],
        ];
    }
}
