<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $tokenResult = auth()->user()->createToken('accessToken');
            $token = $tokenResult->accessToken;

            if ($request->input('remember_me')) {
                $token->expires_at = Carbon::now()->addWeeks(1);
            }

            $tokenResult->token->save();

            $oauthClient = DB::table('oauth_clients')
                ->where('password_client', true)
                ->first();

            $data = [
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'client_id' => $oauthClient->id,
                'client_secret' => $oauthClient->secret,
            ];

            return redirect('/lista-trabajos')->with('data', $data);

        } else {

            return response()->json([
                'message' => 'Usuario o contraseña incorrectos',
            ], 401);
        }
    }
}
