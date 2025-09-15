<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRegistrationRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function register(CustomerRegistrationRequest $request)
    {
        $customer = Customer::create($request->validated());
        $token = $customer->createToken('auth_token')->plainTextToken;

        return $this->createdResponse([
            'customer' => new CustomerResource($customer),
            'token' => $token,
            'token_type' => 'Bearer'
        ], 'Customer registered successfully');
    }
}
