<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Mail\TemporaryPassword;
use App\Models\Carpark;
use App\Models\Companies;
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
        $registered_users = User::active()->orderBy('created_at', 'desc')->paginate(config('app.item_per_page'));
        return view('app.User.index', compact('page_title', 'registered_users'));
    }

    public function create()
    {
        $roles = Roles::all();
        $page_title = "Add User";
        $user_info = null;
		$carparks = Carpark::select('id', 'name')->active()->orderBy('name', 'asc')->get();
        return view('app.User.create', compact('roles', 'page_title', 'user_info', 'carparks'));
    }

    public function store(UserFormRequest $request)
    {
        try {

            if ($request->isMethod('post')) {
                $form_user   = $request->except(['_token', 'first_name', 'last_name']);
                $form_member = $request->only(['first_name', 'last_name', 'company']);

                DB::beginTransaction();

                $temporary_password = str_random(8);
                $form_user['password'] = $temporary_password;

                if ($user = Sentinel::registerAndActivate($form_user)) {
                	if (!is_null($form_member['company']['company_name'])) {
						$company = Companies::create($form_member['company']);

						// create member info
						$member = Members::create([
							'user_id'    => $user->id,
							'company_id' => $company->id,
							'first_name' => $form_member['first_name'],
							'last_name'  => $form_member['last_name'],
							'is_active'  => 1
						]);
					} else {
						// create member info
						$member = Members::create([
							'user_id'    => $user->id,
							'first_name' => $form_member['first_name'],
							'last_name'  => $form_member['last_name'],
							'is_active'  => 1
						]);
					}

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
        	dd($e);
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
                    $registered_users = $result->paginate(config('app.item_per_page'));

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

    public function delete($id)
    {
        $response = ['success' => false];
        if (User::findOrFail($id)->update(['deleted_at' => date('Y-m-d H:i:s')])) {
            $response = ['success' => true];
        }

        return response()->json($response);
    }

    public function profile()
    {
        $user = Sentinel::getUser();
        $roles = Roles::all();
        $page_title = "Profile of ".$user->members->first_name." ".$user->members->last_name;
        return view('app.User.profile', compact('roles', 'page_title'));
    }

    public function update(UserFormRequest $request)
    {
        try {

            if ($request->isMethod('post')) {
                $user = (isset($request->id)) ? User::findOrFail($request->id) : Sentinel::getUser();

                $form_user   = $request->except(['_token', 'first_name', 'last_name', 'password', 'confirm_password']);
                $form_member = $request->only(['first_name', 'last_name', 'company']);

                if ($user->update($form_user)) {
                    // update member details
                    $user->members->update([
                    	'first_name' => $form_member['first_name'],
                    	'last_name' => $form_member['last_name'],
                    	'company_id' => $form_member['company']['company_name'],
					]);

                    // check if role is still the same
                    if ($user->roles[0]->id != $form_user['role_id']) {
                        $role = Sentinel::findRoleByName($user->roles[0]->name);
                        $role->users()->detach($user);

                        // attach user to new role
                        $role = Sentinel::findRoleById($form_user['role_id']);
                        $role->users()->attach($user);
                    }

                    return redirect('/admin/users')->with('success', 'User details has been updated');
                } else {
                    return back()->with('error', 'Error in updating user details');
                }
            } else {
                return back()->with('error', 'Invalid request');
            }

        } catch (\Exception $e) {
        	dd($e);
            abort(404, $e->getMessage());
        }
    }

    public function reset($id)
    {
        $response = ['success' => false];
        $temporary_password = str_random(8);
        $user = User::findOrFail($id);
        if ($user->update(['password' => $temporary_password])) {
            Mail::to($user->email)->send(new TemporaryPassword(['password' => $temporary_password]));
            $response = ['success' => true];
        }

        return response()->json($response);
    }

    public function edit($id)
    {
        $user_info = User::findOrFail($id);
        $roles = Roles::all();
        $page_title = "Profile of ".$user_info->members->first_name." ".$user_info->members->last_name;
		$carparks = Carpark::select('id', 'name')->active()->orderBy('name', 'asc')->get();
        return view('app.User.edit', compact('roles', 'page_title', 'user_info', 'carparks'));
    }
}
