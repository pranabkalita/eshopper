<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'address_id' => 'required|numeric',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'items' => 'required|array',
            'items.*.product_id' => 'required|numeric',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|numeric',
            'items.*.price' => 'required|numeric',
        ];
    }
}
