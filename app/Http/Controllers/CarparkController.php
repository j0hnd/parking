<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarparkFormRequest;
use App\Models\Carpark;
use App\Models\Tools\Countries;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CarparkController extends Controller
{
    public function index()
    {
        $carparks = Carpark::active()->orderBy('name', 'asc')->paginate(config('app.item_per_page'));
        $page_title = "Currently Listed Carparks";
        return view('app.Carpark.index', compact('carparks', 'page_title'));
    }

    public function create()
    {
        $countries = Countries::all();
        $page_title = "Add Carpark";
        return view('app.Carpark.create', compact('countries', 'page_title'));
    }

    public function store(Request $request)
    {
        try {

            if ($request->isMethod('post')) {

                $form = $request->except('_token');
                $current = Carbon::now();

                if ($carpark = Carpark::create($form)) {
                    $path = 'uploads/carparks/' . $current->format('Y-m-d');
                    if ($request->hasFile('image')) {
                        $image = \Request::file('image');
                        $filename   = $image->getClientOriginalName();
                        $image_path = "{$path}/".$carpark->id;

                        if ($image->move($image_path, $filename)) {
                            Carpark::where('id', $carpark->id)->update(['image' => $image_path."/".$filename]);
                        }
                    }

                    return redirect('/admin/carpark')->with('success', 'New carpark has been added');
                } else {
                    return back()->with('error', 'Error in adding new carpark');
                }

            } else {
                return back()->with('error', 'Invalid request');
            }

        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }
    }

    public function edit($id)
    {
        $carpark = Carpark::findOrFail($id);
        $countries = Countries::all();
        $page_title = "Edit ".$carpark->name;
        return view('app.Carpark.edit', compact('countries', 'page_title', 'carpark'));
    }

    public function update(CarparkFormRequest $request)
    {
        try {

            if ($request->isMethod('post')) {
                $form = $request->except(['_token', 'id', 'image']);
                $id = $request->get('id');
                $current = Carbon::now();
                $path = 'uploads/carparks/' . $current->format('Y-m-d');
                $carpark = Carpark::findOrFail($id);

                if ($carpark->update($form)) {
                    if ($request->hasFile('image')) {
                        $image = \Request::file('image');
                        $filename   = $image->getClientOriginalName();
                        $image_path = "{$path}/".$carpark->id;

                        if ($image->move($image_path, $filename)) {
                            Carpark::where('id', $carpark->id)->update(['image' => $image_path."/".$filename]);
                        }
                    }

                    return redirect('/admin/carpark')->with('success', 'Carpark details has been updated');
                } else {
                    return back()->with('error', 'Error in updating carpark details');
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
        if (Carpark::findOrFail($id)->update(['deleted_at' => date('Y-m-d H:i:s')])) {
            $response = ['success' => true];
        }

        return response()->json($response);
    }

    public function search(Request $request)
    {
        try {

            if ($request->isMethod('post')) {
                $form = $request->except('_token');
                $result = Carpark::search($form['search']);
                if (!is_null($result)) {
                    $page_title = "Currently Listed Carparks";
                    $carparks = $result->paginate(config('app.item_per_page'));

                    return view('app.Carpark.index', compact('carparks', 'page_title'));
                } else {
                    return redirect('/admin/carpark')->with('error', 'No data found');
                }

            } else {
                return redirect('/admin/carpark')->with('error', 'Invalid request');
            }

        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }
    }
}
