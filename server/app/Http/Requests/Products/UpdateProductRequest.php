<?php

namespace App\Http\Requests\Products;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'category_id' => 'nullable|numeric',
            'brand_id' => 'nullable|numeric',
            'name' => 'nullable|string|min:3',
            'description' => 'nullable|min:25',
            'price' => 'nullable|numeric',
            'isPublished' => 'nullable|boolean',
            'isPromoted' => 'nullable|boolean',
            'images' => 'nullable|array'
        ];

        if (auth()->user()->hasRole(User::ROLES['SUPER_ADMIN'])) {
            $validators['user_id'] = 'required|numeric';
        }

        return $validators;
    }
}
