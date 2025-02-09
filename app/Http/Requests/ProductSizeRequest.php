<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSizeRequest extends FormRequest
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
            'size' => 'required|unique:product_sizes,size,' . optional($this->size)->id . ',id',
            'price' => 'required|numeric',
            'modal' => 'required|numeric',
            'stock' => 'required|numeric',
        ];
    }
}
