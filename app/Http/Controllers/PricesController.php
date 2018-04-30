<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Tools\Prices;
use Illuminate\Http\Request;

class PricesController extends Controller
{
    public function get_price(Request $request)
    {
        $product = Products::findOrFail($request->product_id);
        $price = Prices::findOrFail($request->price_id);

        return response()->json(['id' => $price->id, 'price_value' => $price->price_value, 'revenue_share' => $product->revenue_share]);
    }
}
