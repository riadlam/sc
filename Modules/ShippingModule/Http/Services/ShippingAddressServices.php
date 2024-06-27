<?php

namespace Modules\ShippingModule\Http\Services;

use App\Models\UserDeliveryAddress;
use Illuminate\Http\JsonResponse;
use Modules\ShippingModule\Entities\ShippingAddress;

class ShippingAddressServices
{
    public static function store($data, $isApi = false): JsonResponse
    {
        $query = UserDeliveryAddress::updateOrCreate(
            [
                'user_id' => $data['user_id']
            ], $data);

        return response()->json([
            'success' => (bool) $query ?? false,
            "msg" => !empty($query) ? "Successfully created new shipping address" : "Failed to create new shipping address" ,
            'data' => $query,
        ]);
    }
}
