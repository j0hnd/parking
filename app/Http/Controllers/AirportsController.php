<?php

namespace App\Http\Controllers;

use App\Http\Requests\AirportRequestForm;
use App\Models\Airports;
use App\Models\Tools\Countries;
use App\Models\Tools\Subcategories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;


class AirportsController extends Controller
{
    public function index()
    {
        $airports = Airports::active()->orderBy('airport_name', 'asc')->paginate(config('app.item_per_page'));
        $page_title = "Currently Listed Airports";
        return view('app.Airport.index', compact('airports', 'page_title'));
    }

    public function create()
    {
        $countries = Countries::all();
        $page_title = "Add Airport";
        return view('app.Airport.create', compact('countries', 'page_title'));
    }

    public function store(AirportRequestForm $request)
    {
        try {

            if ($request->isMethod('post')) {

                $form = $request->except(['_token', 'subcategory']);
                $current = Carbon::now();

                DB::beginTransaction();

                if ($airport = Airports::create($form)) {
                    // upload image
                    $path = 'uploads/airports/' . $current->format('Y-m-d');
                    if ($request->hasFile('image')) {
                        $image = \Request::file('image');
                        $filename   = $image->getClientOriginalName();
                        $image_path = "{$path}/".$airport->id;

                        if ($image->move($image_path, $filename)) {
                            Airports::where('id', $airport->id)->update(['image' => $image_path."/".$filename]);
                        }
                    }

                    // set subcategories
                    $subcategories = $request->get('subcategory');
                    if (count($subcategories)) {
                        foreach ($subcategories as $sub) {
                            Subcategories::updateOrCreate([
                                'airport_id' => $airport->id,
                                'subcategory_name' => $sub
                            ],
                            [
                                'airport_id' => $airport->id,
                                'subcategory_name' => $sub,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                        }
                    }

                    DB::commit();

                    return redirect('/admin/airport')->with('success', 'New airport has been added');
                } else {
                    DB::rollback();

                    return back()->with('error', 'Error in adding new airport');
                }

            } else {
                DB::rollback();

                return back()->with('error', 'Invalid request');
            }

        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }
    }

    public function edit($id)
    {
        $airport   = Airports::findOrFail($id);
        $airports  = Airports::active();
        $countries = Countries::all();

        $subcategories = [];
        $page_title = "Edit ".$airport->airport_name;

        if (count($airport->subcategories)) {
            foreach ($airport->subcategories as $sub) {
                $subcategories[] = $sub->subcategory_name;
            }
        }

        return view('app.Airport.edit', compact('countries', 'page_title', 'airport', 'airports', 'subcategories'));
    }

    public function update(AirportRequestForm $request)
    {
        try {

            if ($request->isMethod('post')) {
                $form = $request->except(['_token', 'id', 'subcategory']);
                $sub_category = $request->get('subcategory');
                $id = $request->get('id');
                $current = Carbon::now();
                $path = 'uploads/airports/' . $current->format('Y-m-d');
                $airport = Airports::findOrFail($id);

                if ($airport->update($form)) {
                    if ($request->hasFile('image')) {
                        $image = \Request::file('image');
                        $filename   = $image->getClientOriginalName();
                        $image_path = "{$path}/".$airport->id;

                        if ($image->move($image_path, $filename)) {
                            Airports::where('id', $airport->id)->update(['image' => $image_path."/".$filename]);
                        }
                    }

                    if (count($sub_category)) {
                        foreach ($sub_category as $sub) {
                            Subcategories::updateOrCreate(
                                ['airport_id' => $airport->id, 'subcategory_name' => $sub],
                                ['airport_id' => $airport->id,
                                    'subcategory_name' => $sub,
                                    'updated_at' => Carbon::now()]
                            );
                        }
                    }

                    return redirect('/admin/airport')->with('success', 'Airport details has been updated');
                } else {
                    return back()->with('error', 'Error in updating airport details');
                }
            } else {
                return back()->with('error', 'Invalid request');
            }

        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }
    }

    public function delete($id)
    {
        $response = ['success' => false];
        if (Airports::findOrFail($id)->update(['deleted_at' => date('Y-m-d H:i:s')])) {
            $response = ['success' => true];
        }

        return response()->json($response);
    }

    public function search(Request $request)
    {
        try {

            if ($request->isMethod('post')) {
                $form = $request->except('_token');
                $result = Airports::search($form['search']);
                if (!is_null($result)) {
                    $page_title = "Currently Listed Airports";
                    $airports = $result->paginate(config('app.item_per_page'));

                    return view('app.Airport.index', compact('airports', 'page_title'));
                } else {
                    return redirect('/admin/airport')->with('error', 'No data found');
                }

            } else {
                return redirect('/admin/airport')->with('error', 'Invalid request');
            }

        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }
    }
}
