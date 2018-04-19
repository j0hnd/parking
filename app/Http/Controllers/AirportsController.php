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
        $airports = Airports::active()->orderBy('airport_name', 'asc')->paginate(15);
        $page_title = "Currently Listed Airports";
        return view('app.Airport.index', compact('airports', 'page_title'));
    }

    public function create()
    {
        $countries = Countries::all();
        $subcategories = Airports::select(['id', 'airport_name'])->orderBy('created_at', 'desc');
        $page_title = "Add Airport";
        return view('app.Airport.create', compact('countries', 'subcategories', 'page_title'));
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
                            Subcategories::insert([
                                'airport_id' => $airport->id,
                                'subcategory_id' => $sub
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
        $airport = Airports::findOrFail($id);
        $countries = Countries::all();
        $page_title = "Edit ".$airport->airport_name;
        return view('app.Airport.edit', compact('countries', 'page_title', 'airport'));
    }

    public function update(AirportRequestForm $request)
    {
        try {

            if ($request->isMethod('post')) {
                $form = $request->except(['_token', 'id']);
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
                    $airports = $result->paginate(15);

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
