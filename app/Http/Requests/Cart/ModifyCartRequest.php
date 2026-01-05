<?php

namespace App\Http\Requests\Cart;

use App\Helpers\Sanitize;
use Illuminate\Foundation\Http\FormRequest;

class ModifyCartRequest extends FormRequest
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

		$productId = (int) Sanitize::input($this->input('productId'));
		$quantity = (int) Sanitize::input($this->input('quantity'));
		$operation = (string) Sanitize::input($this->input('operation'));

		$this->merge([
			'productId'		=>	$productId,
			'quantity'		=>	$quantity,
			'operation'		=>	$operation
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
            'operation' 	=> 'required|in:add,sub',
        ];
    }
}
