<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // AuthenticatesUsersトレイトのauthenticatedメソッドをオーバーライド
    protected function authenticated(Request $request, $user)
    {
        // ログイン成功時、ログインユーザーに表示させたいページへ遷移し、フラッシュメッセージを表示
        return redirect()->intended($this->redirectPath())->with('success', 'ログインに成功しました。');
    }

    // AuthenticatesUsersトレイトのlogoutメソッドをオーバーライド
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // ログアウト成功時、トップ画面へ遷移し、フラッシュメッセージを表示
        return redirect()->route('top')->with('success', 'ログアウトしました。');
    }
}
