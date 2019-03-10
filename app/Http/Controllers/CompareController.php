<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\TwitterAccount;
use App\User;
use App\TwitterAccountLog;
use App\Competitor;
use App\TwitterTweet;
use App\TwitterReply;
use Carbon\Carbon;

class CompareController extends Controller
{

  protected $request;

  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function index()
  {
    $competitors = [];
    // $competitorTemp = DB::select('select competitor_id as competitor_id from competitor where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id .'\'');
    $competitorsTemp = Competitor::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->get();
    foreach($competitorsTemp as $competitorTemp) {
      $temp = TwitterAccountLog::where('twitter_id','=',$competitorTemp->competitor_id)->orderBy('created_at','desc')->first();
      array_push($competitors,$temp);
    }
    return view('contents.competitor', [
      'account' => Auth::user(),
      'competitors' => $competitors
    ]);
  }

  public function compare($id)
  {
    $competitor = TwitterAccountLog::where('twitter_id','=',$id)->orderBy('created_at','desc')->first();
    return view('contents.compare', [
      'account' => Auth::user(),
      'competitor' => $competitor
    ]);
  }

  public function search($username)
  {
    $result = shell_exec("python " . public_path() . "\API\SearchTwitter.py " . $username);
    $result = json_decode($result);
    $isCompetitor = false;
    $twitter_id = TwitterAccount::where('account_id','=',Auth::user()->id)->distinct('twitter_id')->first();
    $check = Competitor::where('twitter_id','=',$twitter_id->twitter_id)->where('competitor_id','=',$result[0]->user_id)->first();
    if(!empty($check)) {
      $isCompetitor = true;
    }

    return response()->json(
      [
        'status' => 200,
        'message' => 'success',
        'response' => [
          'profile' => $result,
          'isEngage' => $isCompetitor
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

    $userTwitterID = TwitterAccount::where('account_id','=',Auth::user()->id)->first();
    $competitor = new Competitor;
    $competitor->twitter_id = $userTwitterID->twitter_id;
    $competitor->competitor_id = $response[0]->user_id;

    if($twitterAccountLog->save() && $competitor->save()){
      return response()->json([
        'status' =>200,
        'message' => 'berhasil menambah kompetitor'
      ]);
    } else {
      return response()->json([
        'status' => 405,
        'message' => 'gagal menambah kompetitor'
      ]);
    }
  }

  public function deleteAccount($idCompetitor)
  {
    $twitter_id = TwitterAccount::where('account_id','=',Auth::user()->id)->distinct('twitter_id')->first();
    if($delete = Competitor::where([
      'twitter_id' => $twitter_id->twitter_id,
      'competitor_id' => $idCompetitor
    ])->delete()){
      return response()-> json([
        'status'=> 200,
        'message'=> 'competitor has been successfully deleted'
      ]);
    } else {
      return response()->json([
        'status'=> 401,
        'message'=> 'failed delete competitor'
      ]);
    }
  }

  public function showCompetitorAccount($id)
  {
    $accountData = TwitterAccountLog::where('twitter_id','=',$id)->orderBy('created_at','desc')->first();

    return response()->json(
            [
              'status' => 200,
              'message' => 'success',
              'response' => $accountData
            ]
    );
  }

  public function showComparisonAccount($id)
  {
    $accountData = TwitterAccountLog::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->orderBy('created_at','desc')->first();
    $accountDataComp = TwitterAccountLog::where('twitter_id','=',$id)->orderBy('created_at','desc')->first();

    $followersNow = TwitterAccountLog::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->orderBy('created_at','desc')->first();
    $followersWeekAgo = TwitterAccountLog::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->where('created_at','>=', Carbon::today()->subWeek())->first();
    $followers = $followersNow->followers_count - $followersWeekAgo->followers_count;

    $tweetsUser = TwitterTweet::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->where('created_at','>=', Carbon::today()->subWeek())->get();

    $posts = $tweetsUser->count();
    $retweets = $tweetsUser->sum('retweet_count');
    $likes = $tweetsUser->sum('favorite_count');
    $replies = $tweetsUser->sum('replies_count');


    $followersNow = TwitterAccountLog::where('twitter_id','=',$id)->orderBy('created_at','desc')->first();
    $followersWeekAgo = TwitterAccountLog::where('twitter_id','=',$id)->where('created_at','>=', Carbon::today()->subWeek())->first();
    $followersComp = $followersNow->followers_count - $followersWeekAgo->followers_count;

    $tweetsComp = TwitterTweet::where('twitter_id','=',$id)->where('created_at','>=', Carbon::today()->subWeek())->get();

    $postsComp = $tweetsComp->count();
    $retweetsComp = $tweetsComp->sum('retweet_count');
    $likesComp = $tweetsComp->sum('favorite_count');
    $repliesComp = $tweetsComp->sum('replies_count');

    $followersChart = [];
    $followersCompChart = [];
    $postingChart = [];
    $postingCompChart = [];
    $retweetChart = [];
    $retweetCompChart = [];;
    $likesChart = [];
    $likesCompChart = [];
    $repliesChart = [];
    $repliesCompChart = [];

    for ($i=0; $i <= 8; $i++) {
      $getFollowersNow = TwitterAccountLog::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->whereDate('created_at','=',Carbon::now()->subDays($i)->toDateString())->orderBy('created_at','desc')->first();
      $getFollowersYesterday = TwitterAccountLog::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->whereDate('created_at','=',Carbon::now()->subDays($i+1)->toDateString())->orderBy('created_at','desc')->first();
      if(!empty($getFollowersNow->followers_count) && !empty($getFollowersYesterday)) {
        $tempFollowers = $getFollowersNow->followers_count - $getFollowersYesterday->followers_count;
        $tempTweets = TwitterTweet::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->whereDate('tweet_created','=',Carbon::now()->subDays($i)->toDateString())->get();

        array_push($postingChart,$tempTweets->count());
        array_push($retweetChart,$tempTweets->sum('retweet_count'));
        array_push($likesChart,$tempTweets->sum('favorite_count'));
        array_push($repliesChart,$tempTweets->sum('replies_count'));
      } else {
        $tempFollowers = 0;
        array_push($postingChart,0);
        array_push($retweetChart,0);
        array_push($likesChart,0);
        array_push($repliesChart,0);
      }
      array_push($followersChart,$tempFollowers);

      $getFollowersNow = TwitterAccountLog::where('twitter_id','=',$id)->whereDate('created_at','=',Carbon::now()->subDays($i)->toDateString())->orderBy('created_at','desc')->first();
      $getFollowersYesterday = TwitterAccountLog::where('twitter_id','=',$id)->whereDate('created_at','=',Carbon::now()->subDays($i+1)->toDateString())->orderBy('created_at','desc')->first();
      if(!empty($getFollowersNow->followers_count) && !empty($getFollowersYesterday)) {
        $tempFollowers = $getFollowersNow->followers_count - $getFollowersYesterday->followers_count;
        $tempCompTweets = TwitterTweet::where('twitter_id','=',$id)->whereDate('tweet_created','=',Carbon::now()->subDays($i)->toDateString())->get();
        array_push($postingCompChart,$tempCompTweets->count());
        array_push($retweetCompChart,$tempCompTweets->sum('retweet_count'));
        array_push($likesCompChart,$tempCompTweets->sum('favorite_count'));
        array_push($repliesCompChart,$tempCompTweets->sum('replies_count'));
      } else {
        $tempFollowers = 0;
        array_push($postingCompChart,0);
        array_push($retweetCompChart,0);
        array_push($likesCompChart,0);
        array_push($repliesCompChart,0);
      }
      array_push($followersCompChart,$tempFollowers);
    }

    return response()->json(
            [
              'status' => 200,
              'message' => 'success',
              'accountData' => $accountData,
              'accountDataComp' => $accountDataComp,
              'followers' => $followers,
              'posts' => $posts,
              'retweets' => $retweets,
              'likes' => $likes,
              'replies' => $replies,
              'followersComp' => $followersComp,
              'postsComp' => $postsComp,
              'retweetsComp' => $retweetsComp,
              'likesComp' => $likesComp,
              'repliesComp' => $repliesComp,
              'followersChart' => $followersChart,
              'followersCompChart' => $followersCompChart,
              'postingChart' => $postingChart,
              'postingCompChart' => $postingCompChart,
              'likesChart' => $likesChart,
              'likesCompChart' => $likesCompChart,
              'retweetChart' => $retweetChart,
              'retweetCompChart' => $retweetCompChart,
              'repliesChart' => $repliesChart,
              'repliesCompChart' => $repliesCompChart
            ]
    );
  }
}
