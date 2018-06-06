<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFormRequest;
use App\Models\Airports;
use App\Models\Carpark;
use App\Models\Overrides;
use App\Models\ProductAirports;
use App\Models\Products;
use App\Models\Services;
use App\Models\Tools\CarparkServices;
use App\Models\Tools\PriceCategories;
use App\Models\Tools\Prices;
use Carbon\Carbon;
use Cartalyst\Sentinel\Sentinel;
use DB;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $page_title = 'Product Listing';
        $products = Products::active()->paginate(config('app.item_per_page'));
        return view('app.Product.index', compact('page_title', 'products'));
    }

    public function create()
    {
        $page_title = 'Add Product';
        $carparks = Carpark::active()->orderBy('name', 'asc');
        $airports = Airports::active()->orderBy('airport_name', 'asc');
        $priceCategories = PriceCategories::active();
        $carparkServices = CarparkServices::active()->orderBy('service_name', 'asc');
        $row_count = 1;

        $timestamp = strtotime('next Sunday');
        $days = array();
        for ($i = 0; $i < 7; $i++) {
            $days[] = strftime('%A', $timestamp);
            $timestamp = strtotime('+1 day', $timestamp);
        }

        for ($m = 1; $m <= 12; $m++) {
            $months[] = date('F', mktime(0,0,0,$m, 1, date('Y')));
        }

        $years [] = (int) date('Y');
        for ($y = 1; $y <= 30; $y++) {
            $years[] = date('Y') + $y;
        }

        return view('app.Product.create', compact(
            'page_title',
            'carparks',
            'airports',
            'priceCategories',
            'carparkServices',
            'row_count',
            'days',
            'months',
            'years'
        ));
    }

    public function store(ProductFormRequest $request)
    {
        try {

            if ($request->isMethod('post')) {
                $form = $request->only(['carpark_id' , 'description', 'on_arrival', 'on_return', 'revenue_share', 'prices', 'services', 'overrides']);
                $airports = $request->get('airport_id');

                DB::beginTransaction();

                $user = Sentinel::getUser();
                $role = $user->roles()->get();
				$form['vendor_id'] = ($role[0]->slug == 'vendor') ? $user->id : 0;

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
                                        'no_of_days'      => $form['prices']['no_of_days'][1][$i],
                                        'price_month'     => $form['prices']['price_month'][2][$i],
                                        'price_year'      => $form['prices']['price_year'][3][$i],
                                        'price_value'     => $form['prices']['price_value'][4][$i]
                                    ];
                                }
                            }
                        }

                        foreach ($prices_form as $pform) {
                            Prices::create($pform);
                        }
                    }

                    if (isset($form['overrides'])) {
                        foreach ($form['overrides'] as $overrides) {
                            foreach ($overrides as $key => $values) {
                                foreach ($values as $i => $val) {
                                    $override_form[$i] = [
                                        'product_id'     => $products->id,
                                        'override_dates' => $form['overrides']['override_dates'][0][$i],
                                        'override_price' => $form['overrides']['override_price'][1][$i]
                                    ];
                                }
                            }
                        }

                        foreach ($override_form as $oform) {
                            Overrides::create($oform);
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
            abort(404, $e->getMessage());
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

        $timestamp = strtotime('next Sunday');
        $days = array();
        for ($i = 0; $i < 7; $i++) {
            $days[] = strftime('%A', $timestamp);
            $timestamp = strtotime('+1 day', $timestamp);
        }

        for ($m = 1; $m <= 12; $m++) {
            $months[] = date('F', mktime(0,0,0,$m, 1, date('Y')));
        }

        $years [] = (int) date('Y');
        for ($y = 1; $y <= 30; $y++) {
            $years[] = date('Y') + $y;
        }

        return view('app.Product.create', compact(
            'page_title',
            'product',
            'carparks',
            'airports',
            'priceCategories',
            'carparkServices',
            'selectedServices',
            'row_count',
            'days',
            'months',
            'years'
        ));
    }

    public function update(Request $request)
    {
        try {

            if ($request->isMethod('post')) {
                $product = Products::findOrFail($request->product_id);
                $form = $request->only(['carpark_id' , 'description', 'on_arrival', 'on_return', 'revenue_share', 'prices', 'services', 'overrides']);
                $airports = $request->get('airport_id');

                DB::beginTransaction();
                $product->carpark_id     = $form['carpark_id'];
                $product->description    = $form['description'];
                $product->on_arrival     = $form['on_arrival'];
                $product->on_return      = $form['on_return'];
                $product->revenue_share  = $form['revenue_share'];

                if ($product->save()) {
                    // update airports
                    if (count($airports)) {
                        $product->airport()->detach();
                        ProductAirports::where(['product_id' => $product->id])->delete();

                        foreach ($airports as $airport) {
                            $product->airport()->attach($product->id, [
                                'product_id' => $product->id,
                                'airport_id' => (int) $airport,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                        }
                    }

                    DB::commit();

                    if (isset($form['prices'])) {
                        Prices::where('product_id', $product->id)->delete();

                        foreach ($form['prices'] as $field => $prices) {
                            foreach ($prices as $key => $values) {
                                foreach ($values as $i => $val) {
                                    $prices_form[$i] = [
                                        'product_id'      => $product->id,
										'category_id'     => $form['prices']['category_id'][0][$i],
										'no_of_days'      => isset($form['prices']['no_of_days'][1][$i]) ? $form['prices']['no_of_days'][1][$i] : null,
										'price_month'     => $form['prices']['price_month'][2][$i],
										'price_year'      => $form['prices']['price_year'][3][$i],
										'price_value'     => $form['prices']['price_value'][4][$i]
                                    ];
                                }
                            }
                        }

                        foreach ($prices_form as $pform) {
                            Prices::create($pform);
                        }
                    }

					if (isset($form['overrides'])) {
                    	Overrides::where('product_id', $product->id)->delete();

						foreach ($form['overrides'] as $overrides) {
							foreach ($overrides as $key => $values) {
								foreach ($values as $i => $val) {
									$override_form[$i] = [
										'product_id'     => $product->id,
										'override_dates' => $form['overrides']['override_dates'][0][$i],
										'override_price' => $form['overrides']['override_price'][1][$i]
									];
								}
							}
						}

						foreach ($override_form as $oform) {
							Overrides::create($oform);
						}
					}

                    // update services
                    if (isset($form['services'])) {
                        $product->carpark_services()->detach();
                        Services::where('product_id', $product->id)->delete();

                        foreach ($form['services'] as $service) {
                            $product->carpark_services()->attach($product->id, [
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
            abort(404, $e->getMessage());
        }
    }
}
