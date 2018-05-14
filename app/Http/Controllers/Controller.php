<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Sentinel;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $role;
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (\Request::wantsJson()) {
                return $next($request);
            } else {
                if (Sentinel::check()) {
                    $this->user = Sentinel::getUser();
                    $this->role = $this->user->roles()->get();
                    if ($this->role[0]->slug == 'administrator') {
                        view()->share('user', $this->user);
                        view()->share('role', $this->role->toArray());
                        return $next($request);
                    } else {
                        Sentinel::logout();
                        return redirect()->to('/');
                    }
                } else {
                    Sentinel::logout();
                    return redirect()->to('login');
                }
            }
        });
    }
}
