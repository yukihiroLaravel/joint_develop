<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    // ログイン処理
    public function login(Request $request)
    {
        // バリデーション
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 認証処理
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // intended が送信されていれば、それをセッションに保存
            if ($request->has('intended')) {
                session(['url.intended' => $request->input('intended')]);
            }
            // ログイン成功時のフラッシュメッセージ
            session()->flash('success', 'ログインに成功しました');

            // intended に保存されているURLがあればそこへリダイレクト、なければデフォルトのページへ
            return redirect()->intended();
        }

        // 認証失敗時の処理
        return back()->withErrors(['email' => '認証に失敗しました'])->withInput();
    }

    // ログアウト処理
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // ログアウト後のフラッシュメッセージ
        session()->flash('success', 'ログアウトしました');

        return redirect()->route('post.list');
    }
}
