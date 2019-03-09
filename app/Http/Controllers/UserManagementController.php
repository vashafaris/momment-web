<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{

  protected $request;

  public function __construct(Request $request)
  {
    $this->middleware('guest', ['except' => 'logout']);

    $this->request = $request;
  }

  public function showLoginForm()
  {
    return view('auth.login');
  }

  public function showRegisterForm()
  {
    return view('auth.register');
  }

  public function submitLoginForm()
  {
    $credential = $this->request->only('email', 'password');
    if ($this->login($credential)) {
      return redirect('/');
    } else {
      Session::flash('login-error', 'E-mail/Password tidak cocok, silahkan coba lagi');
      return redirect('/login');
    }
  }

  public function submitRegisterForm()
  {
    // With Validator
    $validator = Validator::make($this->request->all(), User::$password_rules, User::$messages);
    $user = User::where('email','=',$this->request->email)->get();
    if(empty($user[0]) == true) {
      if (!$validator->fails()) {

        User::create([
          'name' => $this->request->post('name'),
          'email' => $this->request->post('email'),
          'password' => bcrypt($this->request->post('password'))
        ]);

        // Auto login
        $credential = $this->request->only('email', 'password');
        if ($this->login($credential)) {
          return redirect('/');
        } else {
          Session::flash('register-error', 'Autologin failed.');
          return redirect('/register');
        }
      } else {
        return redirect('/register?token=' . $this->request->post('_reset-token'))
        ->withErrors($validator, 'register')
        ->withInput();
      }
    } else {
      Session::flash('register-error', 'E-mail telah terdaftar');
      return redirect('/register');
    }
  }

  public function logout()
  {
    $userdata = Auth::user();

    Auth::logout();

    return redirect('/login');
  }

  protected function login($credential)
  {
    if ($account = Auth::attempt($credential, true)) {
      $userdata = Auth::user();
      return $account;
    } else {
      return false;
    }
  }

}
