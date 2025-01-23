<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'selectedProducts' => 'required|array',
            'selectedProducts.*.id' => 'required|integer|exists:products,id',
            'selectedProducts.*.name' => 'required|string|max:255',
            'selectedProducts.*.size' => 'required|string',
            'selectedProducts.*.price' => 'required|integer|min:0',
            'selectedProducts.*.quantity' => 'required|integer|min:1',
            'totalPrice' => 'required|integer|min:0',
            'totalQuantity' => 'required|integer|min:0',
        ];
    }
}
