<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\TwitterAccount;
use App\User;
use App\TwitterAccountLog;
use Kozz\Laravel\Facades\Guzzle;
use GuzzleHttp\Client;

class EngageController extends Controller
{
  protected $request;

  public function __construct(Request $request)
  {
      $this->request = $request;
  }

  public function index()
  {
      if (TwitterAccount::where('account_id', '=', Auth::user()->id)->where('is_account', '=', '1')->exists()) {

        $accountData = TwitterAccountLog::get();

        return view('contents.account', [
            'accountData' => $accountData
        ]);
      }
      return view('contents.engage');
  }

  public function search($username)
  {
    $result = shell_exec("python " . public_path() . "\API\SearchTwitter.py " . $username);
    $result = json_decode($result);
   $isEngage = false;
    if (TwitterAccount::where('twitter_id', '=', $result[0]->user_id)->where('is_account', '=' ,'1')->exists()) {
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

  public function addAccount($username)
  {
    $result = shell_exec("python " . public_path() . "\API\SearchTwitter.py " . $username);
    $response = json_decode($result);
    $twitterAccount = new TwitterAccount;
    $twitterAccount->twitter_id= $response[0]->user_id;
    $twitterAccount->account_id = Auth::user()->id;
    $twitterAccount->is_account = 1;


    $twitterAccountLog = new TwitterAccountLog;
    $twitterAccountLog->twitter_id= $response[0]->user_id;
    $twitterAccountLog->name = $response[0]->name;
    $twitterAccountLog->screen_name = $response[0]->screen_name;
    $twitterAccountLog->photo_url = $response[0]->photo_url;
    $twitterAccountLog->banner_url = $response[0]->banner_url;
    $twitterAccountLog->description = $response[0]->description;
    $twitterAccountLog->favorites_count = $response[0]->favorites_count;
    $twitterAccountLog->followers_count = $response[0]->followers_count;
    $twitterAccountLog->friends_count = $response[0]->friends_count;
    $twitterAccountLog->statuses_count = $response[0]->statuses_count;
    $twitterAccountLog->location = $response[0]->location;
    $twitterAccountLog->created = $response[0]->created;
    if($twitterAccount->save() && $twitterAccountLog->save()){
      return response()->json([
        'status' =>200,
        'message' => 'berhasil menyambungkan akun'
      ]);
    } else {
      return response()->json([
        'status' => 405,
        'message' => 'gagal menyambungkan akun'
      ]);
    }
  }

  public function showAccount()
  {
    // $accountData = DB::select('select top 1 * from twitter_accounts_log where twitter_id = (select twitter_id from twitter_accounts where account_id = ' . Auth::user()->id . ') order by created_at desc');
    $accountData = TwitterAccountLog::where('twitter_id',Auth::user()->twitterAccount->twitter_id)->orderBy('created_at','desc')->first();

    return response()->json(
            [
              'status' => 200,
              'message' => 'success',
              'response' => $accountData
            ]
    );
  }
}
