<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $page_title = "List of Users";
        $registered_users = User::active()->orderBy('created_at', 'desc')->paginate(15);
        return view('app.User.index', compact('page_title', 'registered_users'));
    }

    public function search(Request $request)
    {
        try {

            if ($request->isMethod('post')) {
                $form = $request->except('_token');
                $result = User::search($form['search']);
                if (!is_null($result)) {
                    $page_title = "List of Users";
                    $registered_users = $result->paginate(15);

                    return view('app.User.index', compact('registered_users', 'page_title'));
                } else {
                    return redirect('/admin/users')->with('error', 'No data found');
                }

            } else {
                return redirect('/admin/users')->with('error', 'Invalid request');
            }

        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }
    }
}
