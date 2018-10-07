<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFormRequest;
use App\Models\Airports;
use App\Models\Carpark;
use App\Models\Closure;
use App\Models\Overrides;
use App\Models\ProductAirports;
use App\Models\Products;
use App\Models\Services;
use App\Models\ProductContactDetails;
use App\Models\Tools\CarparkServices;
use App\Models\Tools\PriceCategories;
use App\Models\Tools\Prices;
use Carbon\Carbon;
use Sentinel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

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
        $row_count_cd = 1;
        $override_count = 1;

        $timestamp = strtotime('next Sunday');
        $days = array();
        for ($i = 0; $i < 7; $i++) {
            $days[] = strftime('%A', $timestamp);
            $timestamp = strtotime('+1 day', $timestamp);
        }

        for ($m = 1; $m <= 12; $m++) {
            $months[] = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
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
            'override_count',
            'days',
            'months',
            'years',
            'row_count_cd'
        ));
    }

    public function store(ProductFormRequest $request)
    {
        try {
            if ($request->isMethod('post')) {
                $form = $request->only([
                    'carpark_id',
                    'short_description',
                    'description',
                    'on_arrival',
                    'on_return',
                    'directions',
                    'revenue_share',
                    'prices',
                    'services',
                    'overrides',
                    'closure',
                    'contact_details'
                ]);

                $form_contact_details = $request->only(['contact_person_name', 'contact_person_email', 'contact_person_phone_no']);

                $airports = $request->get('airport_id');

                $current = Carbon::now();

                DB::beginTransaction();

                $user = Sentinel::getUser();
                $role = $user->roles()->get();
                $form['vendor_id'] = ($role[0]->slug == 'vendor') ? $user->id : 0;

                if ($products = Products::create($form)) {
                    $path = 'uploads/products/' . $current->format('Y-m-d');
                    if ($request->hasFile('image')) {
                        $image = \Request::file('image');
                        $filename   = $image->getClientOriginalName();
                        $image_path = "{$path}/".$products->id;

                        // check if upload folder is existing, if not create it
                        if (!File::exists(public_path($path))) {
                            File::makeDirectory(public_path($path));
                        }

                        if (!File::exists(public_path($image_path))) {
                            File::makeDirectory(public_path($image_path));
                        }

                        $image_resize = Image::make($image->getRealPath());
                        $image_resize->resize(219, 129);

                        $image_resize->save(public_path("{$image_path}/{$filename}"));
                        Products::where('id', $products->id)->update(['image' => $image_path."/".$filename]);
                    }

                    foreach ($airports as $airport) {
                        ProductAirports::create([
                            'product_id' => $products->id,
                            'airport_id' => $airport
                        ]);
                    }

                    if (isset($form_contact_details)) {
                        $contact_details = [
                            'carpark_id'              => $form['carpark_id'],
                            'product_id'              => $products->id,
                            'contact_person_name'     => $form_contact_details['contact_person_name'],
                            'contact_person_email'    => $form_contact_details['contact_person_email'],
                            'contact_person_phone_no' => $form_contact_details['contact_person_phone_no'],
                            'is_active'               => 1
                        ];

                        ProductContactDetails::create($contact_details);
                    }

                    if (isset($form['prices'])) {
                        foreach ($form['prices'] as $field => $prices) {
                            foreach ($prices as $key => $values) {
                                foreach ($values as $i => $val) {
                                    $prices_form[$i] = [
                                        'product_id'  => $products->id,
                                        'category_id' => $form['prices']['category_id'][0][0],
                                        'no_of_days'  => $form['prices']['no_of_days'][1][$i],
                                        'price_month' => $form['prices']['price_month'][2][$i],
                                        'price_year'  => $form['prices']['price_year'][3][$i],
                                        'price_value' => $form['prices']['price_value'][4][$i]
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
                                    if (!is_null($form['overrides']['override_dates'][0][$i])) {
                                        $override_form[$i] = [
                                            'product_id'     => $products->id,
                                            'override_dates' => $form['overrides']['override_dates'][0][$i],
                                            'override_price' => $form['overrides']['override_price'][1][$i]
                                        ];
                                    }
                                }
                            }
                        }

                        if (isset($override_form)) {
                            foreach ($override_form as $oform) {
                                Overrides::create($oform);
                            }
                        }
                    }

                    if (isset($form['closure'])) {
                        Closure::where('product_id', $products->id)->delete();

                        foreach ($form['closure'] as $closures) {
                            foreach ($closures as $key => $value) {
                                $closure_form[$key] = [
                                    'product_id'  => $products->id,
                                    'closed_date' => $value,
                                ];
                            }
                        }

                        if (isset($closure_form)) {
                            foreach ($closure_form as $cform) {
                                Closure::create($cform);
                            }
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
        $page_title = "Edit Product";
        $product    = Products::findOrFail($id);
        $carparks   = Carpark::active()->orderBy('name', 'desc');
        $airports   = Airports::active()->orderBy('airport_name', 'desc');
        $priceCategories = PriceCategories::active();
        $carparkServices = CarparkServices::active()->orderBy('service_name', 'asc');

        $row_count = count($product->prices) ? count($product->prices) : 1;
        $row_count_cd = count($product->closures) ? count($product->closures) : 1;
        $override_count = count($product->overrides) ? count($product->overrides) : 1;

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
            $months[] = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
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
            'override_count',
            'days',
            'months',
            'years',
            'row_count_cd'
        ));
    }

    public function update(ProductFormRequest $request)
    {
        try {
            if ($request->isMethod('post')) {
                $product = Products::findOrFail($request->product_id);
                $form = $request->only([
                    'carpark_id',
                    'short_description',
                    'description',
                    'on_arrival',
                    'on_return',
                    'directions',
                    'revenue_share',
                    'price_ids',
                    'prices',
                    'services',
                    'overrides',
                    'closure',
                    'contact_details'
                ]);

                $form_contact_details = $request->only(['contact_person_name', 'contact_person_email', 'contact_person_phone_no']);

                $airports = $request->get('airport_id');

                DB::beginTransaction();
                $product->carpark_id        = $form['carpark_id'];
                $product->short_description = $form['short_description'];
                $product->description       = $form['description'];
                $product->on_arrival        = $form['on_arrival'];
                $product->on_return         = $form['on_return'];
                $product->directions        = $form['directions'];
                $product->revenue_share     = $form['revenue_share'];

                if ($product->save()) {
                    $current = Carbon::now();
                    $path = 'uploads/products/' . $current->format('Y-m-d');

                    // update contact details
                    if (!is_null($form_contact_details)) {
                        if (is_null($product->contact_details)) {
                            $form_contact_details['product_id'] = $product->id;
                            $form_contact_details['carpark_id'] = $form['carpark_id'];
                            ProductContactDetails::create($form_contact_details);
                        } else {
                            $contact_details = ProductContactDetails::findOrFail($product->contact_details->id);

                            $contact_details->contact_person_name     = $form_contact_details['contact_person_name'];
                            $contact_details->contact_person_email    = $form_contact_details['contact_person_email'];
                            $contact_details->contact_person_phone_no = $form_contact_details['contact_person_phone_no'];

                            $contact_details->save();
                        }
                    }

                    if ($request->hasFile('image')) {
                        $image = \Request::file('image');
                        $filename   = $image->getClientOriginalName();
                        $image_path = "{$path}/".$product->id;

                        // check if upload folder is existing, if not create it
                        if (!File::exists(public_path($path))) {
                            File::makeDirectory(public_path($path));
                        }

                        if (!File::exists(public_path($image_path))) {
                            File::makeDirectory(public_path($image_path));
                        }

                        $image_resize = Image::make($image->getRealPath());
                        $image_resize->resize(219, 129);

                        $image_resize->save(public_path("{$image_path}/{$filename}"));
                        Products::where('id', $product->id)->update(['image' => $image_path."/".$filename]);
                    }

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

                    // delete selected price
                    if (isset($form['price_ids'])) {
                        $price_ids = explode(':', $form['price_ids']);
                        if (count($price_ids)) {
                            foreach ($price_ids as $id) {
                                Prices::where('id', $id)->delete();
                            }
                        }
					}

                    if (isset($form['prices'])) {
                         foreach ($form['prices'] as $field => $prices) {
                             foreach ($prices as $key => $values) {
                                 foreach ($values as $i => $val) {
                                 	$price_ids[$i] = [
										'id' => $form['prices']['id'][5][$i]
									];

                                 	$prices_form[$i] = [
										'product_id'  => $product->id,
										'category_id' => $form['prices']['category_id'][0][0],
										'no_of_days'  => isset($form['prices']['no_of_days'][1][$i]) ? $form['prices']['no_of_days'][1][$i] : null,
										'price_month' => $form['prices']['price_month'][2][$i],
										'price_year'  => $form['prices']['price_year'][3][$i],
										'price_value' => $form['prices']['price_value'][4][$i]
									];
                                 }
                             }
                         }

                         if (isset($price_ids) and isset($prices_form)) {
                         	foreach ($prices_form as $i => $form) {
                         		Prices::updateOrCreate($price_ids[$i], $form);
							}
						 }
                    }

                    if (isset($form['overrides'])) {
                        Overrides::where('product_id', $product->id)->delete();

                        foreach ($form['overrides'] as $overrides) {
                            foreach ($overrides as $key => $values) {
                                foreach ($values as $i => $val) {
                                    if (!is_null($form['overrides']['override_dates'][0][$i])) {
                                        $override_form[$i] = [
                                            'product_id'     => $product->id,
                                            'override_dates' => $form['overrides']['override_dates'][0][$i],
                                            'override_price' => $form['overrides']['override_price'][1][$i]
                                        ];
                                    }
                                }
                            }
                        }

                        if (isset($override_form)) {
                            foreach ($override_form as $oform) {
                                Overrides::create($oform);
                            }
                        }
                    }

                    if (isset($form['closure'])) {
                        Closure::where('product_id', $product->id)->delete();

                        foreach ($form['closure'] as $closures) {
                            foreach ($closures as $key => $value) {
                                if (!empty($value)) {
                                    $closure_form[$key] = [
                                        'product_id'  => $product->id,
                                        'closed_date' => $value,
                                    ];
                                }
                            }
                        }

                        if (isset($closure_form)) {
                            foreach ($closure_form as $cform) {
                                Closure::create($cform);
                            }
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
            dd($e);
            abort(404, $e->getMessage());
        }
    }
}
