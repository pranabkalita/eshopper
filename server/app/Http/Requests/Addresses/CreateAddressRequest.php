<?php

namespace App\Http\Requests\Addresses;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateAddressRequest extends FormRequest
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
            'address_line_1' => 'required|string',
            'address_line_2' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|numeric',
            'country' => 'required|string',
            'phone' => 'required|string',
            'alternate_phone' => 'required|string',
            'is_active' => 'required|boolean',
        ];

        if (auth()->user()->hasRole([User::ROLES['SUPER_ADMIN'], User::ROLES['ADMIN']])) {
            $validators['user_id'] = 'required|numeric';
        }

        return $validators;
    }
}
