<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Validator;
use App\Models\User;


use Illuminate\Support\Str;
use Auth;
use DB;
use Hash;
use Input;
use Session;
use View;
use SoapFault;
use Translate;
use Excel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

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
        $this->middleware('guest')->except(['logout','changepassword','postchangepassword']);
    }

    public function username()
    {
        return 'User_Logon';
    }

    public function login(Request $request){
        $this->validateLogin($request);

        $user = User::getLogon($request->input("User_Logon"), $request->input("password"))
        ->first();

        if(!empty($user)){

            if(!empty($user['user_passwordreset']) && $user['user_passwordreset'] == 'Y')
            {
                auth()->guard('web')->login($user);
                return redirect()->route('changepassword');
            }
            else{
                auth()->guard('web')->login($user);
                return redirect()->route('cs.index');
            }
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function forgotpassword(){

        return view('forgot');

        return redirect()->route("login");
	}

    public function postforgotpassword(){

        $data = request()->input();

        $rules = [
            'logon' => 'required',
        ];

        $validator = Validator::make($data, $rules);

        if(!$validator->fails()){
            $user = User::where("User_Logon",$data['logon'])->first();

            if(!empty($user)){
                $email = $user['User_EmailAddress'];

                $status = 'fail';

                if(!empty($email)){

                    $password = Str::random(10);
                    $resetPassword = $password;
                    $user->user_webpassword = $password;
                    $user->user_passwordreset = "Y";
                    $user->user_sentemail = "Y";
                    $user->save();
                    $status = 'success';
                }

                return redirect()->route('resetpassword')->with('status', $status)->with('email', $email)->with('p', 'y');

            }
            $validator->errors()->add('logon', __('error.forgot_password'));
        }

        return redirect()->route('forgot')
        ->withErrors($validator)
        ->withInput(Input::except('password'));

        return redirect()->route('login');
	}

    public function resetpassword(){
		$p = session('p', 'p');

		if($p != ''){
			return view('reset')->with('p', $p)->with('status', session('status', ''))->with('email', session('email', ''));
        }

        return redirect()->route('login');
	}

    public function changepassword(){

		$user = auth()->user();

        // dd($user);

        if($user->user_passwordreset == 'Y'){
            return view('changepassword');
        }else{
            return redirect()->route('cs.index');
        }
        return redirect()->route('login');
	}

    public function postchangepassword(){



        $data = request()->input();
        // dd($data);
        $rules = [
            'password' => 'required',
            'confirmpassword' => 'required|same:password',
        ];

        $validator = Validator::make($data, $rules);

        if(!$validator->fails()){
            $user = Auth::guard('web')->user(); // guard web is default



            $user->user_webpassword = $data['password'] ?? null;
            $user->user_passwordreset = null;
            $user->user_sentemail = null;

            if($user->save()){
                return redirect()->route("cs.index")->with("msg.success", __('success.password_update'));
            }
            $validator->errors()->add("custommsg", __('error.password_update'));
        }
        return back()->withErrors($validator);

        return redirect()->route('login');
    }

}
