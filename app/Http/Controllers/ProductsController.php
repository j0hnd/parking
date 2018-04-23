<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFormRequest;
use App\Models\Airports;
use App\Models\Carpark;
use App\Models\ProductAirports;
use App\Models\Products;
use App\Models\Tools\CarparkServices;
use App\Models\Tools\PriceCategories;
use DB;

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
        return view('app.Product.create', compact('page_title', 'carparks', 'airports', 'priceCategories', 'carparkServices'));
    }

    public function store(ProductFormRequest $request)
    {
        try {

            if ($request->isMethod('post')) {
                $form = $request->only(['carpark_id' , 'description', 'on_arrival', 'on_return']);
                $airports = $request->get('airport_id');

                DB::beginTransaction();

                if ($products = Products::create($form)) {
                    foreach ($airports as $airport) {
                        ProductAirports::create([
                            'product_id' => $products->id,
                            'airport_id' => $airport
                        ]);
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
}
