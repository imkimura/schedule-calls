<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerCreateRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class CustomersController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        return response()->json(Customer::where('user_id', $request->user()->id)->get());
    }

    /**
     * @param CustomerCreateRequest $request
     * @return JsonResponse
     */
    public function create(CustomerCreateRequest $request): JsonResponse
    {
        try {
            $customer = [
                'user_id' => $request->user()->id,
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'cellphone' => $request->get('cellphone')
            ];

            if (!empty($request->get('birthday'))) {
                $customer['birthday'] = $request->get('birthday');
            }

            return response()->json(Customer::create($customer)->toArray());
        } catch (\Exception $exception) {
            return response()->json(['' => $exception->getMessage()], 500);
        }
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function read(int $id, Request $request): JsonResponse
    {
        return response()->json(Customer::where('id', $id)->first());
    }

    /**
     * @param int $id
     * @param CustomerUpdateRequest $request
     * @return JsonResponse
     */
    public function update(int $id, CustomerUpdateRequest $request): JsonResponse
    {
        try {
            $customer = Customer::where('id', $id)->first();

            $customer->update($request->all());

            return response()->json($customer);
        } catch (Exception $exception) {
            return response()->json(['' => $exception->getMessage()], 500);
        }
    }
}
