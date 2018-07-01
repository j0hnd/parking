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
					$requestUri = $request->getRequestUri();
                    switch ($this->role[0]->slug) {
						case "administrator":
							if (strpos($requestUri, 'members')) {
								Sentinel::logout();
								return redirect()->to('/member/login');
							}
							view()->share('user', $this->user);
							view()->share('role', $this->role->toArray());
							return $next($request);
							break;

						case "member":
						case "vendor":
						case "travel_agent":
							if (strpos($requestUri, 'admin')) {
								Sentinel::logout();
								return redirect()->to('/admin');
							}
							view()->share('user', $this->user);
							view()->share('role', $this->role->toArray());
							return $next($request);
							break;

						default:
							Sentinel::logout();
							return redirect()->to('/');
							break;
					}
                } else {
                    Sentinel::logout();
                    return redirect()->to('login');
                }
            }
        });
    }
}
