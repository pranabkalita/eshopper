<?php

namespace App\Http\Controllers\Addresses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addresses\CreateAddressRequest;
use App\Http\Requests\Addresses\UpdateAddressRequest;
use App\Http\Resources\Addresses\AddressResource;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddressController extends Controller
{

    public function index()
    {
        return AddressResource::collection(Address::all());
    }

    public function store(CreateAddressRequest $request)
    {
        $data = $request->only('address_line_1', 'address_line_2', 'city', 'state', 'zip', 'country', 'phone', 'alternate_phone', 'is_active');

        $address = auth()->user()->addresses()->create($data);

        return (new AddressResource($address))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Address $address)
    {
        return new AddressResource($address);
    }

    public function update(UpdateAddressRequest $request, Address $address)
    {
        $data = [
            'address_line_1' => $request->has('address_line_1') ? $request->address_line_1 : $address->address_line_1,
            'address_line_2' => $request->has('address_line_2') ? $request->address_line_2 : $address->address_line_2,
            'city' => $request->has('city') ? $request->city : $address->city,
            'state' => $request->has('state') ? $request->state : $address->state,
            'zip' => $request->has('zip') ? $request->zip : $address->zip,
            'country' => $request->has('country') ? $request->country : $address->country,
            'phone' => $request->has('phone') ? $request->phone : $address->phone,
            'alternative_phone' => $request->has('alternative_phone') ? $request->alternative_phone : $address->alternative_phone,
            'is_active' => $request->has('is_active') ? $request->is_active : $address->is_active,
        ];

        if ($request->has('is_active')) {
            auth()->user()->addresses()->update(['is_active' => false]);
        }

        if (auth()->user()->hasRole([User::ROLES['SUPER_ADMIN'], User::ROLES['ADMIN']])) {
            $data['user_id'] = $request->has('user_id') ? $request->user_id : $address->user_id;
            $address->update($data);
        } else {
            $address->update($data);
        }

        return new AddressResource($address);
    }

    public function destroy(Address $address)
    {
        $address->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
