<?php

namespace App\Http\Controllers;

use App\Http\Requests\AirportRequestForm;
use App\Models\Airports;
use App\Models\Tools\Countries;
use Illuminate\Http\Request;

class AirportsController extends Controller
{
    public function index()
    {
        $airports = Airports::active()->orderBy('airport_name', 'asc');
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

                $form = $request->except('_token');

                if (Airports::create($form)) {
                    return redirect('/admin/airport')->with('success', 'New airport has been added');
                } else {
                    return back()->with('error', 'Error in adding new airport');
                }

            } else {
                return back()->with('error', 'Invalid request');
            }

        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }
    }
}
