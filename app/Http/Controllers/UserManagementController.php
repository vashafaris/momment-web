<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
      // $token = $this->request->get('token');
      // if (!is_null($token)) {
      //     $user = User::where('reset_password_token', $token)->with(['account', 'role', 'department'])->first();
      //     if (!is_null($user)) {
      //         return view('auth.register', [
      //             'user' => $user
      //         ]);
      //     } else {
      //         Session::flash('register-error', 'Invalid registration tokens.');
      //         return view('auth.register');
      //     }
      // } else {
      //     Session::flash('register-error', 'Invalid registration token.');
      //     return view('auth.register');
      // }
      return view('auth.register');
  }

  public function submitLoginForm()
  {
      $credential = $this->request->only('email', 'password');
      if ($this->login($credential)) {
          return redirect('/');
      } else {
          Session::flash('login-error', 'Wrong username/password. Try again.');
          return redirect('/login');
      }
  }

  public function submitRegisterForm()
  {
      // With Validator
      $validator = Validator::make($this->request->all(), User::$password_rules, User::$messages);
      if (!$validator->fails()) {

          // $user->password = bcrypt($this->request->post('password'));
          // $user->update();

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
