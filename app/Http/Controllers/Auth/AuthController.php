<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	
use AuthenticatesAndRegistersUsers;

	//protected $redirectTo = '/form/userlist';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;


		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/* Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsersの
	 * postLogin、redirectPath、getLogoutをオーバーライドする
	 */
	public function postLogin(Request $request)
	{
		$this->validate($request, [
				'email' => 'required|email', 'password' => 'required',
		]);

		$credentials = $request->only('email', 'password');

		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
			return redirect()->intended($this->redirectPath());
		}

		return redirect($this->loginPath())
		->withInput($request->only('email', 'remember'))
		->withErrors([
				'email' => $this->getFailedLoginMessage(),
		]);
	}

	public function redirectPath()
	{
		if (property_exists($this, 'redirectPath'))
		{
			return $this->redirectPath;
		}

		return property_exists($this, 'redirectTo') ? $this->redirectTo : '/form/userlist';
	}

	public function getLogout(){

		$this->auth->logout();

		return redirect('/auth/login');

	}


}
