<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\TwitterAccount;
use App\User;
use App\TwitterAccountLog;

class CompareController extends Controller
{

  protected $request;

  public function __construct(Request $request)
  {
      $this->request = $request;
  }

  public function index()
  {
      return view('contents.compare', [
          'account' => Auth::user()
      ]);
  }

  public function search($username)
  {
    $result = shell_exec("python " . public_path() . "\API\SearchTwitter.py " . $username);
    $result = json_decode($result);
   $isEngage = false;
    if (TwitterAccount::where('twitter_id', '=', $result[0]->user_id)->where('is_competitor', '=' ,'1')->exists()) {
       $isEngage = true;
    }

    return response()->json(
            [
                'status' => 200,
                'message' => 'success',
                'response' => [
                    'profile' => $result,
                    'isEngage' => $isEngage
                ]
            ]
    );
  }
}
