<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\TwitterAccount;
use App\User;
use App\TwitterAccountLog;
use App\Competitor;

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

  public function addAccount($username)
  {
    $result = shell_exec("python " . public_path() . "\API\SearchTwitter.py " . $username);
    $response = json_decode($result);
    if (TwitterAccount::where('twitter_id', '=', $response[0]->user_id)->exists()){
      TwitterAccount::where('twitter_id', $response[0]->user_id)->update(['is_competitor' => 1]);
    } else {
      $twitterAccount = new TwitterAccount;
      $twitterAccount->twitter_id= $response[0]->user_id;
      $twitterAccount->is_competitor = 1;
      $twitterAccount->save();
    }

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

    $userTwitterID = DB::select('select twitter_id from twitter_accounts where account_id = ' . Auth::user()->id);
    $competitor = new Competitor;
    $competitor->account_id = $userTwitterID[0]->twitter_id;
    $competitor->competitor_id = $response[0]->user_id;

    if($twitterAccountLog->save() && $competitor->save()){
      return response()->json([
        'status' =>200,
        'message' => 'berhasil menambah kompetitor'
      ]);
    } else {
      return response()->json([
        'status' => 405,
        'message' => 'berhasil menambah kompetitor'
      ]);
    }
  }
}
