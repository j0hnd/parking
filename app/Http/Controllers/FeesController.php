<?php

namespace App\Http\Controllers;

use App\Models\Tools\Fees;
use Illuminate\Http\Request;

class FeesController extends Controller
{
	public function index()
	{
		$fees = Fees::active()->get();
		$page_title = 'Fees';
		return view('app.Fees.index', compact('fees', 'page_title'));
	}

	public function delete($id)
	{
		$response = ['success' => false];
		if (Fees::findOrFail($id)->update(['deleted_at' => date('Y-m-d H:i:s')])) {
			$response = ['success' => true];
		}

		return response()->json($response);
	}

	public function edit($id)
	{
		$fee = Fees::findOrFail($id);
		$page_title = 'Edit ' . ucwords(str_replace('_', ' ', $fee->fee_name));
		return view('app.Fees.edit', compact('fee', 'page_title'));
	}

	public function update(Request $request)
	{
		try {

			if ($request->isMethod('post')) {
				$form = $request->only(['id', 'amount']);
				if (Fees::where('id', $form['id'])->update(['amount' => $form['amount']])) {
					return redirect('/admin/fees')->with('success', 'Fee has been updated');
				} else {
					return back()->withErrors(['errors' => 'Error in updating fee']);
				}
			} else {
				return back()->withErrors(['errors' => 'Invalid request']);
			}

		} catch (\Exception $e) {
			abort(404, $e->getMessage());
		}
	}
}
