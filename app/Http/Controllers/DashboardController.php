<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  protected $request;

  public function __construct(Request $request)
  {
      $this->request = $request;
  }

  public function index()
  {
      if (!Auth::user()->twitterAccount){
        return view('contents.engage', [
          'account' => Auth::user()
        ]);
      } else {
        return view('contents.dashboard', [
            'account' => Auth::user()
        ]);
      }

  }

  public function login()
  {
      return view('auth.login');
  }

  public function register()
  {
      return view('auth.register');
  }
}
