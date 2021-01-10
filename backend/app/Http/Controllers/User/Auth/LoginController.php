<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:user')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('user');
    }

    public function showLoginForm()
    {
        return view('user.auth.login');
    }

    //ゲストログイン
    public function guest()
    {
        $email = 'guest@example.com';
        $password = 'password';

        if(Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect()->route('home')->with('flash_message', 'ゲストユーザーとしてログインしました');
        }

        return redirect('/')->with('flash_message', 'ログインに失敗しました');
    }

    //flash_messageを表示させるためsendLoginResponseをオーバーライド
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        //dd($request);
        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath())->with('flash_message', 'ログインしました');
    }

    //flash_messageを表示させるためlogoutをオーバーライド
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect('/')->with('flash_message', 'ログアウトしました');
    }

}
