<?php

namespace App\Http\Requests\Products;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
        $validators = [
            'category_id' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'name' => 'required|string|min:3',
            'description' => 'required|min:25',
            'price' => 'required|numeric',
            'isPublished' => 'nullable|boolean',
            'isPromoted' => 'nullable|boolean',
            'images' => 'required|array'
        ];

        if (auth()->user()->hasRole(User::ROLES['SUPER_ADMIN'])) {
            $validators['user_id'] = 'required|numeric';
        }

        return $validators;
    }
}
