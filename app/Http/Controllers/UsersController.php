<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Mail\TemporaryPassword;
use App\Models\Members;
use App\Models\Tools\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Sentinel;
use DB;

class UsersController extends Controller
{
    public function index()
    {
        $page_title = "List of Users";
        $registered_users = User::active()->orderBy('created_at', 'desc')->paginate(15);
        return view('app.User.index', compact('page_title', 'registered_users'));
    }

    public function create()
    {
        $roles = Roles::all();
        $page_title = "Add User";
        return view('app.User.create', compact('roles', 'page_title'));
    }

    public function store(UserFormRequest $request)
    {
        try {

            if ($request->isMethod('post')) {

                $form_user = $request->except(['_token', 'first_name', 'last_name']);
                $form_member = $request->only(['first_name', 'last_name']);

                DB::beginTransaction();

                $temporary_password = str_random(8);
                $form_user['password'] = $temporary_password;

                if ($user = Sentinel::register($form_user)) {
                    // create member info
                    Members::create([
                        'user_id'    => $user->id,
                        'first_name' => $form_member['first_name'],
                        'last_name'  => $form_member['last_name'],
                        'is_active'  => 1
                    ]);

                    // assign role to a user
                    $role = Sentinel::findRoleById($form_user['role_id']);
                    $role->users()->attach($user);

                    Mail::to($form_user['email'])->send(new TemporaryPassword(['password' => $temporary_password]));

                    DB::commit();

                    return redirect('/admin/users')->with('success', 'New user has been added');
                } else {
                    DB::rollback();

                    return back()->with('error', 'Error in adding new user');
                }

            } else {
                DB::rollback();

                return back()->with('error', 'Invalid request');
            }

        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }
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
