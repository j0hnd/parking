<?php

namespace App\Http\Controllers;

use App\Http\Requests\AffiliateFormRequest;
use App\Models\Affiliates;
use App\Models\Members;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use Hash;



class AffiliatesController extends Controller
{
    public function index()
	{
		$page_title = 'Affiliates';
		$affiliates = Affiliates::active()->paginate(config('app.item_per_page'));
		return view('app.Affiliates.index', ['page_title' => $page_title, 'affiliates' => $affiliates]);
	}

	public function create()
	{
		$page_title = 'Create Affiliates';
		$travel_agents = User::whereHas('roles', function ($query) {
				return $query->where('slug', 'travel_agent');
			})
			->whereNull('deleted_at');

		return view('app.Affiliates.create', ['page_title' => $page_title, 'travel_agents' => $travel_agents]);
	}

	public function store(AffiliateFormRequest $request)
	{
		try {
			if ($request->isMethod('post')) {
				$form = $request->except(['_token']);

				DB::beginTransaction();

				if (Affiliates::create($form)) {
					$member = Members::whereNull('deleted_at')->where('user_id', $form['travel_agent_id'])->first();
					$member->update(['affiliate_id' => Str::uuid()]);

					DB::commit();

					return redirect('/admin/affiliates')->with('success', 'Affiliate has been generated');
				} else {
					DB::rollback();
					return back()->withErrors(['error' => 'Unable to generate an affiliate reference']);
				}
			} else {
				DB::rollback();
				return back()->with('success', 'Invalid request');
			}
		} catch (\Exception $e) {
			DB::rollback();
			return back()->withErrors(['error' => $e->getMessage()]);
		}
	}

	public function edit(Request $request)
	{
		$page_title = 'Edit Affiliates';
		$affiliate = Affiliates::findOrFail($request->affiliate);
		$travel_agents = User::whereHas('roles', function ($query) {
			return $query->where('slug', 'travel_agent');
		})
			->whereNull('deleted_at');

		return view('app.Affiliates.edit', ['page_title' => $page_title, 'travel_agents' => $travel_agents, 'affiliate' => $affiliate]);
	}

	public function update(AffiliateFormRequest $request)
	{
		try {
			if ($request->isMethod('post')) {
				$form = $request->except(['_token', 'id']);
				$affiliate_id = $request->get('id');
				$affiliate = Affiliates::findOrFail($affiliate_id);

				if ($affiliate->update($form)) {
					return redirect('/admin/affiliates')->with('success', 'Affiliate has been updated');
				} else {
					return back()->withErrors(['error' => 'Unable to update the selected affiliate reference']);
				}
			} else {
				return back()->with('success', 'Invalid request');
			}
		} catch (\Exception $e) {
			return back()->withErrors(['error' => $e->getMessage()]);
		}
	}

	public function delete($id)
	{
		$response = ['success' => false];
		if (Affiliates::findOrFail($id)->update(['deleted_at' => date('Y-m-d H:i:s')])) {
			$response = ['success' => true];
		}

		return response()->json($response);
	}

	public function search(Request $request)
	{
		try {
			if ($request->isMethod('post')) {
				$form = $request->except('_token');
				$result = Affiliates::search($form['search']);
				if (!is_null($result)) {
					$page_title = "Affiliates";
					foreach ($result->get() as $affiliate) {
						$ids[] = $affiliate->id;
					}

					$affiliates = Affiliates::whereIn('id', $ids)->paginate(config('app.item_per_page'));

					return view('app.Affiliates.index', compact('affiliates', 'page_title'));
				} else {
					return redirect('/admin/affiliates')->with('error', 'No data found');
				}

			} else {
				return redirect('/admin/affiliates')->with('error', 'Invalid request');
			}
		} catch (\Exception $e) {
			abort(404, $e->getMessage());
		}
	}
}
