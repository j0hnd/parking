<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tools\CompanyHouse;
use App\Models\Products;

class AutoCompleteController extends Controller
{
    protected $items_per_page = 100;

    public function get_revenue_share(Request $request)
    {
        $response = ['success' => false];

        try {
            $product = Products::findOrFail($request->product_id);
            $price = $request->get('price');
            $revenue_share = number_format($price * ($product->revenue_share / 100), 2);

            $response = ['success' => true, 'data' => $revenue_share];
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return response()->json($response);
    }

    public function company(Request $request)
    {
        $response = ['success' => false];
        $companies = [];

        try {
            for ($i = 0; $i <= 3; $i++) {
                $result = $this->get_results($request->company_name, $i);

                if ($result['success'] and count($result['body'])) {

                    if (isset($result['body']['items'])) {
                        $items = $result['body']['items'];
                    } else {
                        $items = $result['body'];
                    }

                    foreach ($items as $item) {
                        $companies[] = $item['title'];
                    }
                }
            }

            $response = ['success' => true, 'data' => $companies];
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }


        return response()->json($response);
    }

    private function get_results($company_name, $start_index = 0)
    {
        if ($start_index !== 0) {
            $start_index = ($this->items_per_page * $start_index) + 1;

            // known issue with the api: http://forum.aws.chdev.org/t/search-company-officers-returns-http-416-when-start-index-over-300/897
            if ($start_index == 301) {
                $start_index = 300;
            }
        }

        $api = new CompanyHouse();
        return $api->get('/search/companies?q='.$company_name.'&items_per_page='.$this->items_per_page.'&start_index='.$start_index);
    }
}
