<?php

namespace App\Http\Requests\Addresses;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
            'address_line_1' => 'nullable|string',
            'address_line_2' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip' => 'nullable|numeric',
            'country' => 'nullable|string',
            'phone' => 'nullable|string',
            'alternate_phone' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ];

        if (auth()->user()->hasRole([User::ROLES['SUPER_ADMIN'], User::ROLES['ADMIN']])) {
            $validators['user_id'] = 'nullable|numeric';
        }

        return $validators;
    }
}
