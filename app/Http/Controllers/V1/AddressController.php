<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $addresses = Address::query()->paginate();
        return $this->successResponse('Addresss retrieved successfully', [
            'addresses' => $addresses,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $address = Address::query()->create($request->all());

        return $this->successResponse('Address created successfully', [
            'address' => $address,
        ], 201);
    }

    public function show(Address $address): JsonResponse
    {
        return $this->successResponse('Address retrieved successfully', [
            'address' => $address,
        ]);
    }

    public function update(Request $request, Address $address): JsonResponse
    {
        $address->update($request->all());

        return $this->successResponse('Address updated successfully', [
            'address' => $address,
        ]);
    }

    public function destroy(Address $address): JsonResponse
    {
        $address->delete();

        return $this->successResponse('Address deleted successfully');
    }
}
