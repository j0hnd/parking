<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFormRequest;
use App\Models\Airports;
use App\Models\Carpark;
use App\Models\ProductAirports;
use App\Models\Products;
use App\Models\Services;
use App\Models\Tools\CarparkServices;
use App\Models\Tools\PriceCategories;
use App\Models\Tools\Prices;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $page_title = 'Product Listing';
        $products = Products::active()->paginate(15);
        return view('app.Product.index', compact('page_title', 'products'));
    }

    public function create()
    {
        $page_title = 'Add Product';
        $carparks = Carpark::active()->orderBy('name', 'desc');
        $airports = Airports::active()->orderBy('airport_name', 'desc');
        $priceCategories = PriceCategories::active();
        $carparkServices = CarparkServices::active()->orderBy('service_name', 'asc');
        $row_count = 1;
        return view('app.Product.create', compact('page_title', 'carparks', 'airports', 'priceCategories', 'carparkServices', 'row_count'));
    }

    public function store(ProductFormRequest $request)
    {
        try {

            if ($request->isMethod('post')) {
                $form = $request->only(['carpark_id' , 'description', 'on_arrival', 'on_return', 'revenue_share', 'prices', 'services']);
                $airports = $request->get('airport_id');

                DB::beginTransaction();

                if ($products = Products::create($form)) {
                    foreach ($airports as $airport) {
                        ProductAirports::create([
                            'product_id' => $products->id,
                            'airport_id' => $airport
                        ]);
                    }

                    if (isset($form['prices'])) {
                        foreach ($form['prices'] as $field => $prices) {
                            foreach ($prices as $key => $values) {
                                foreach ($values as $i => $val) {
                                    $prices_form[$i] = [
                                        'product_id'      => $products->id,
                                        'category_id'     => $form['prices']['category_id'][0][$i],
                                        'price_start_day' => ($form['prices']['price_month'][3][$i]) ? 0 : $form['prices']['price_start_day'][1][$i],
                                        'price_end_day'   => ($form['prices']['price_month'][3][$i]) ? 0 : $form['prices']['price_end_day'][2][$i],
                                        'price_month'     => $form['prices']['price_month'][3][$i],
                                        'price_year'      => $form['prices']['price_year'][4][$i],
                                        'price_value'     => $form['prices']['price_value'][5][$i],
                                    ];
                                }
                            }
                        }

                        foreach ($prices_form as $form) {
                            Prices::create($form);
                        }
                    }

                    if (isset($form['services'])) {
                        foreach ($form['services'] as $service) {
                            Services::create([
                                'product_id' => $products->id,
                                'service_id' => $service
                            ]);
                        }
                    }

                    DB::commit();

                    return redirect('/admin/product')->with('success', 'Product has been added');
                } else {
                    DB::rollback();
                }
            }

        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    public function delete($id)
    {
        $response = ['success' => false];
        if (Products::findOrFail($id)->update(['deleted_at' => date('Y-m-d H:i:s')])) {
            $response = ['success' => true];
        }

        return response()->json($response);
    }

    public function edit($id)
    {
        $product = Products::findOrFail($id);
        $page_title = "Edit Product";
        $carparks = Carpark::active()->orderBy('name', 'desc');
        $airports = Airports::active()->orderBy('airport_name', 'desc');
        $priceCategories = PriceCategories::active();
        $carparkServices = CarparkServices::active()->orderBy('service_name', 'asc');
        $row_count = count($product->prices) ? count($product->prices) : 1;

        // get selected services
        $selectedServices = [];
        if (count($product->carpark_services)) {
            foreach ($product->carpark_services as $service) {
                $selectedServices[$service->id] = $service->service_name;
            }
        }

        return view('app.Product.create', compact(
            'page_title',
            'product',
            'carparks',
            'airports',
            'priceCategories',
            'carparkServices',
            'selectedServices',
            'row_count'
        ));
    }

    public function update(Request $request)
    {
        try {

            if ($request->isMethod('post')) {
                $product = Products::findOrFail($request->product_id);
                $form = $request->only(['carpark_id' , 'description', 'on_arrival', 'on_return', 'revenue_share', 'prices', 'services']);
                $airports = $request->get('airport_id');

                DB::beginTransaction();
                $product->carpark_id    = $form['carpark_id'];
                $product->description   = $form['description'];
                $product->on_arrival    = $form['on_arrival'];
                $product->on_return     = $form['on_return'];
                $product->revenue_share = $form['revenue_share'];

                if ($product->save()) {
                    // update airports
                    ProductAirports::where('product_id', $product->id)->delete();
                    foreach ($airports as $airport) {
                        ProductAirports::create([
                            'product_id' => $product->id,
                            'airport_id' => $airport
                        ]);
                    }

                    // update prices
                    Prices::where('product_id', $product->id)->delete();
                    foreach ($form['prices'] as $field => $prices) {
                        foreach ($prices as $key => $values) {
                            foreach ($values as $i => $val) {
                                $prices_form[$i] = [
                                    'product_id'      => $product->id,
                                    'category_id'     => $form['prices']['category_id'][0][$i],
                                    'price_start_day' => ($form['prices']['price_month'][3][$i]) ? 0 : $form['prices']['price_start_day'][1][$i],
                                    'price_end_day'   => ($form['prices']['price_month'][3][$i]) ? 0 : $form['prices']['price_end_day'][2][$i],
                                    'price_month'     => $form['prices']['price_month'][3][$i],
                                    'price_year'      => $form['prices']['price_year'][4][$i],
                                    'price_value'     => $form['prices']['price_value'][5][$i],
                                ];
                            }
                        }
                    }

                    foreach ($prices_form as $form) {
                        Prices::create($form);
                    }

                    // update services
                    Services::where('product_id', $product->id)->delete();
                    if (isset($form['services'])) {
                        foreach ($form['services'] as $service) {
                            Services::create([
                                'product_id' => $product->id,
                                'service_id' => $service
                            ]);
                        }
                    }
                }

                DB::commit();

                return redirect('/admin/product')->with('success', 'Product has been updated');
            }

        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }
}