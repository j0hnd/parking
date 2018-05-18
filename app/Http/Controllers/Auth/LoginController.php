<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Sentinel;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                // Try to log the user in
                if ($user = Sentinel::authenticate($request->only(['email', 'password']), $request->get('remember-me', false))) {
                    return redirect($this->redirectTo);
                } else {
                    return back()->withErrors('Invalid Username and/or Password');
                }
            } else {
                return view('app.Auth.login');
            }
        } catch (NotActivatedException $e) {
            return back()->withInput()->withErrors('auth/message.account_not_activated');

        } catch (ThrottlingException $e) {
            return back()->withInput()->withErrors('auth/message.account_suspended');

        } catch (UserNotFoundException $e) {
            return back()->withInput()->withErrors('auth/message.user_not_found');

        } catch (ErrorException $e) {
            return back()->withInput()->withErrors('auth/message.unknown_error');
        }
    }

    public function login_member()
	{
		return view('member-portal.login	');
	}

    public function logout(Request $request)
    {
        if (Sentinel::logout()) {
            if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
                return response()->json(['data' => 'User logged out.', 200]);
            } else {
                return redirect('/');
            }
        }
    }
}
