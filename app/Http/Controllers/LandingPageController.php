<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandingPages;
use App\Models\Airports;
use App\Http\Requests\LandingPageFormRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;


class LandingPageController extends Controller
{
    public function index()
    {
        $page_title = "Landing Pages";
        $pages = LandingPages::orderBy('created_at', 'desc')->paginate(config('app.item_per_page'));
        return view('app.Landing.index', ['page_title' => $page_title, 'pages' => $pages]);
    }

    public function create()
    {
        $page_title = "Create Landing Pages";
        $airports = Airports::active()->orderBy('airport_name', 'asc');
        return view('app.Landing.create', ['page_title' => $page_title, 'airports' => $airports]);
    }

    public function store(LandingPageFormRequest $request)
    {
        try {
            $current = Carbon::now();

            if ($request->isMethod('post')) {
                $form = $request->except(['_token']);
                $form['slug'] = str_slug($form['name']);
                $path = 'uploads/pages/' . $current->format('Y-m-d');

                if ($page = LandingPages::create($form)) {
                    if ($request->hasFile('image')) {
    					$image = \Request::file('image');
    					$filename   = $image->getClientOriginalName();
    					$image_path = "{$path}/".$page->id;

    					// check if upload folder is existing, if not create it
    					if (!File::exists(public_path($path))) {
    						File::makeDirectory(public_path($path));
    					}

    					if (!File::exists(public_path($image_path))) {
    						File::makeDirectory(public_path($image_path));
    					}

    					$image_resize = Image::make($image->getRealPath());
    					$image_resize->resize(540, 211);
    					$image_resize->save(public_path("{$image_path}/{$filename}"));
    					LandingPages::where('id', $page->id)->update(['image' => $image_path."/".$filename]);
    				}

                    return back()->with('success', 'Landing page has been saved');
                } else {
                    return back()->withErrors(['error' => 'Unable to save landing page']);
                }
            } else {
                return back()->withErrors(['error' => 'Invalid request']);
            }

        } catch (Exception $e) {
            alert(500, $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $page_title = "Edit Landing Pages";
        $airports = Airports::active()->orderBy('airport_name', 'asc');
        $page = LandingPages::active()->where('id', $request->page)->first();
        return view('app.Landing.edit', ['page_title' => $page_title, 'airports' => $airports, 'page' => $page]);
    }

    public function update(LandingPageFormRequest $request)
    {
        try {
            $current = Carbon::now();

            if ($request->isMethod('post')) {
                $form = $request->except(['_token']);
                $form['slug'] = str_slug($form['name']);
                $page = LandingPages::findOrFail($form['id']);
                $path = 'uploads/pages/' . $current->format('Y-m-d');

                if ($page->update($form)) {
                    if ($request->hasFile('image')) {
    					$image = \Request::file('image');
    					$filename   = $image->getClientOriginalName();
    					$image_path = "{$path}/".$page->id;

    					// check if upload folder is existing, if not create it
    					if (!File::exists(public_path($path))) {
    						File::makeDirectory(public_path($path));
    					}

    					if (!File::exists(public_path($image_path))) {
    						File::makeDirectory(public_path($image_path));
    					}

    					$image_resize = Image::make($image->getRealPath());
    					$image_resize->resize(540, 211);
    					$image_resize->save(public_path("{$image_path}/{$filename}"));
    					LandingPages::where('id', $page->id)->update(['image' => $image_path."/".$filename]);
    				}

                    return back()->with('success', 'Landing page has been updated');
                } else {
                    return back()->withErrors(['error' => 'Unable to update landing page']);
                }
            } else {
                return back()->withErrors(['error' => 'Invalid request']);
            }

        } catch (Exception $e) {
            alert(500, $e->getMessage());
        }
    }

    public function status_update(Request $request)
    {
        $response = ['success' => true];

        try {
            if ($request->ajax()) {
                if ($request->isMethod('post')) {
                    $id = $request->page;
                    $status = $request->get('status');
    				$page = LandingPages::findOrFail($id);

                    if ($status == 'enabled') {
                        $form['deleted_at'] = Carbon::now();
                    } else {
                        $form['deleted_at'] = null;
                    }

                    if ($page->update($form)) {
                        $pages = LandingPages::orderBy('created_at', 'desc')->get();
                        $html = view('app.Landing.partials._list', ['pages' => $pages])->render();
                        $response = ['success' => true, 'message' => 'Landing page has been updated', 'html' => $html];
                    } else {
                        $response['message'] = 'Unable to update landing page status';
                    }
                } else {
                    $response['message'] = 'Error updating status';
                }
            }
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return response()->json($response);
    }
}
