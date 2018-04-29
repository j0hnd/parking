<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;

class CustomersController extends Controller
{
    public function get_customer(Request $request)
    {
        $customer  = Customers::findOrFail($request->id);

        $json_data  = [];

        if (count($customer)) {
            foreach ($customer->first() as $_customer) {
                $json_data = [
                    'id'         => $customer->id,
                    'first_name' => $customer->first_name,
                    'last_name'  => $customer->last_name,
                    'email'      => $customer->email,
                    'mobile_no'  => $customer->mobile_no
                ];
            }
        }

        return response()->json($json_data);
    }
}
