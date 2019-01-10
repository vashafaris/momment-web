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
    $competitors = [];
    $competitorTemp = DB::select('select competitor_id as competitor_id from competitor where twitter_id = ' . Auth::user()->twitterAccount->twitter_id);
    for ($i=0; $i < count($competitorTemp); $i++) {
       $temp = DB::select('select top 1 * from twitter_accounts_log where twitter_id = ' . $competitorTemp[$i]->competitor_id . ' order by created_at desc');
       $competitors[$i] = $temp[0];
    }
    return view('contents.competitor', [
      'account' => Auth::user(),
      'competitors' => $competitors
    ]);
  }

  public function compare($id)
  {
    $competitorTemp = DB::select('select * from twitter_accounts_log where twitter_id = ' . $id);
    $competitor = $competitorTemp[0];
    return view('contents.compare', [
      'account' => Auth::user(),
      'competitor' => $competitor
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
    $competitor->twitter_id = $userTwitterID[0]->twitter_id;
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

  public function showCompetitorAccount($id)
  {
    $accountData = DB::select('select top 1 * from twitter_accounts_log where twitter_id = ' . $id . ' order by created_at desc');

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
    $accountData = DB::select('select top 1 * from twitter_accounts_log where twitter_id = ' . Auth::user()->twitterAccount->twitter_id . ' order by created_at desc');
    $accountDataComp = DB::select('select top 1 * from twitter_accounts_log where twitter_id = ' . $id . ' order by created_at desc');

    $followersNow = DB::select('select top 1 followers_count as followers_count from twitter_accounts_log WHERE NOT (cast(created_at as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(created_at as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = '. Auth::user()->twitterAccount->twitter_id . 'order by created_at desc');
    $followersWeekAgo = DB::select('select top 1 followers_count as followers_count from twitter_accounts_log WHERE NOT (cast(created_at as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(created_at as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = '. Auth::user()->twitterAccount->twitter_id . 'order by created_at asc');
    $followers = ($followersNow[0]->followers_count - $followersWeekAgo[0]->followers_count);

    $posting = DB::select('select count(tweet_id) as posting FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = '. Auth::user()->twitterAccount->twitter_id);
    $posts = $posting[0]->posting;

    $retweet = DB::select('select SUM(retweet_count) as retweet FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = ' . Auth::user()->twitterAccount->twitter_id);
    $retweets = $retweet[0]->retweet;

    $like = DB::select('select SUM(favorite_count) as favorite FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = ' . Auth::user()->twitterAccount->twitter_id);
    $likes = $like[0]->favorite;

    $followersNow = DB::select('select top 1 followers_count as followers_count from twitter_accounts_log WHERE NOT (cast(created_at as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(created_at as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = '. $id . 'order by created_at desc');
    $followersWeekAgo = DB::select('select top 1 followers_count as followers_count from twitter_accounts_log WHERE NOT (cast(created_at as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(created_at as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = '. $id . 'order by created_at asc');
    $followersComp = ($followersNow[0]->followers_count - $followersWeekAgo[0]->followers_count);

    $posting = DB::select('select count(tweet_id) as posting FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = '. $id);
    $postsComp = $posting[0]->posting;

    $retweet = DB::select('select SUM(retweet_count) as retweet FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = ' . $id);
    $retweetsComp = $retweet[0]->retweet;

    $like = DB::select('select SUM(favorite_count) as favorite FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = ' . $id);
    $likesComp = $like[0]->favorite;

    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . Auth::user()->twitterAccount->twitter_id . ' and cast(created_at as date) = DATEADD(day, 0, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . Auth::user()->twitterAccount->twitter_id . ' and cast(created_at as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay0 = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay0 = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . Auth::user()->twitterAccount->twitter_id . ' and cast(created_at as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . Auth::user()->twitterAccount->twitter_id . ' and cast(created_at as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay1 = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay1 = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . Auth::user()->twitterAccount->twitter_id . ' and cast(created_at as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . Auth::user()->twitterAccount->twitter_id . ' and cast(created_at as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay2 = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay2 = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . Auth::user()->twitterAccount->twitter_id . ' and cast(created_at as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . Auth::user()->twitterAccount->twitter_id . ' and cast(created_at as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay3 = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay3 = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . Auth::user()->twitterAccount->twitter_id . ' and cast(created_at as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . Auth::user()->twitterAccount->twitter_id . ' and cast(created_at as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay4 = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay4 = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . Auth::user()->twitterAccount->twitter_id . ' and cast(created_at as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . Auth::user()->twitterAccount->twitter_id . ' and cast(created_at as date) = DATEADD(day, -6, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay5 = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay5 = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . Auth::user()->twitterAccount->twitter_id . ' and cast(created_at as date) = DATEADD(day, -6, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . Auth::user()->twitterAccount->twitter_id . ' and cast(created_at as date) = DATEADD(day, -7, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay6 = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay6 = 0;
    }


    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . $id . ' and cast(created_at as date) = DATEADD(day, 0, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . $id . ' and cast(created_at as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay0Comp = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay0Comp = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . $id . ' and cast(created_at as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . $id . ' and cast(created_at as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay1Comp = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay1Comp = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . $id . ' and cast(created_at as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . $id . ' and cast(created_at as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay2Comp = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay2Comp = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . $id . ' and cast(created_at as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . $id . ' and cast(created_at as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay3Comp = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay3Comp = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . $id . ' and cast(created_at as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . $id . ' and cast(created_at as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay4Comp = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay4Comp = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . $id . ' and cast(created_at as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . $id . ' and cast(created_at as date) = DATEADD(day, -6, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay5Comp = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay5Comp = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' .$id . ' and cast(created_at as date) = DATEADD(day, -6, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = ' . $id . ' and cast(created_at as date) = DATEADD(day, -7, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay6Comp = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay6Comp = 0;
    }

    $postingDay0 = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, 0, convert(date, GETDATE()))');
    $postingDay1 = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    $postingDay2 = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    $postingDay3 = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    $postingDay4 = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    $postingDay5 = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    $postingDay6 = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -6, convert(date, GETDATE()))');



    $postingDay0Comp = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, 0, convert(date, GETDATE()))');
    $postingDay1Comp = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    $postingDay2Comp = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    $postingDay3Comp = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    $postingDay4Comp = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    $postingDay5Comp = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    $postingDay6Comp = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, -6, convert(date, GETDATE()))');

    $retweetDay0 = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, 0, convert(date, GETDATE()))');
    $retweetDay1 = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    $retweetDay2 = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    $retweetDay3 = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    $retweetDay4 = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    $retweetDay5 = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    $retweetDay6 = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -6, convert(date, GETDATE()))');

    $retweetDay0Comp = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, 0, convert(date, GETDATE()))');
    $retweetDay1Comp = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    $retweetDay2Comp = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    $retweetDay3Comp = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    $retweetDay4Comp = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    $retweetDay5Comp = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    $retweetDay6Comp = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, -6, convert(date, GETDATE()))');
    if (empty($retweetDay0Comp)) {
      $retweetDay0Comp = 0;
    }
    if (empty($retweetDay1Comp)) {
      $retweetDay1Comp = 0;
    }
    if (empty($retweetDay2Comp)) {
      $retweetDay2Comp = 0;
    }
    if (empty($retweetDay3Comp)) {
      $retweetDay3Comp = 0;
    }
    if (empty($retweetDay4Comp)) {
      $retweetDay4Comp = 0;
    }
    if (empty($retweetDay5Comp)) {
      $retweetDay5Comp = 0;
    }
    if (empty($retweetDay6Comp)) {
      $retweetDay6Comp = 0;
    }


    $likesDay0 = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, 0, convert(date, GETDATE()))');
    $likesDay1 = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    $likesDay2 = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    $likesDay3 = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    $likesDay4 = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    $likesDay5 = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    $likesDay6 = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -6, convert(date, GETDATE()))');

    $likesDay0Comp = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, 0, convert(date, GETDATE()))');
    $likesDay1Comp = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    $likesDay2Comp = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    $likesDay3Comp = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    $likesDay4Comp = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    $likesDay5Comp = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    $likesDay6Comp = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = '. $id . ' and cast(tweet_created as date) = DATEADD(day, -6, convert(date, GETDATE()))');

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
              'followersComp' => $followersComp,
              'postsComp' => $postsComp,
              'retweetsComp' => $retweetsComp,
              'likesComp' => $likesComp,
              'postingDay0' => $postingDay0,
              'postingDay1' => $postingDay1,
              'postingDay2' => $postingDay2,
              'postingDay3' => $postingDay3,
              'postingDay4' => $postingDay4,
              'postingDay5' => $postingDay5,
              'postingDay6' => $postingDay6,
              'postingDay0Comp' => $postingDay0Comp,
              'postingDay1Comp' => $postingDay1Comp,
              'postingDay2Comp' => $postingDay2Comp,
              'postingDay3Comp' => $postingDay3Comp,
              'postingDay4Comp' => $postingDay4Comp,
              'postingDay5Comp' => $postingDay5Comp,
              'postingDay6Comp' => $postingDay6Comp,
              'retweetDay0' => $retweetDay0,
              'retweetDay1' => $retweetDay1,
              'retweetDay2' => $retweetDay2,
              'retweetDay3' => $retweetDay3,
              'retweetDay4' => $retweetDay4,
              'retweetDay5' => $retweetDay5,
              'retweetDay6' => $retweetDay6,
              'retweetDay0Comp' => $retweetDay0Comp,
              'retweetDay1Comp' => $retweetDay1Comp,
              'retweetDay2Comp' => $retweetDay2Comp,
              'retweetDay3Comp' => $retweetDay3Comp,
              'retweetDay4Comp' => $retweetDay4Comp,
              'retweetDay5Comp' => $retweetDay5Comp,
              'retweetDay6Comp' => $retweetDay6Comp,
              'likesDay0' => $likesDay0,
              'likesDay1' => $likesDay1,
              'likesDay2' => $likesDay2,
              'likesDay3' => $likesDay3,
              'likesDay4' => $likesDay4,
              'likesDay5' => $likesDay5,
              'likesDay6' => $likesDay6,
              'likesDay0Comp' => $likesDay0Comp,
              'likesDay1Comp' => $likesDay1Comp,
              'likesDay2Comp' => $likesDay2Comp,
              'likesDay3Comp' => $likesDay3Comp,
              'likesDay4Comp' => $likesDay4Comp,
              'likesDay5Comp' => $likesDay5Comp,
              'likesDay6Comp' => $likesDay6Comp,
              'followersDay0' => $followersDay0,
              'followersDay1' => $followersDay1,
              'followersDay2' => $followersDay2,
              'followersDay3' => $followersDay3,
              'followersDay4' => $followersDay4,
              'followersDay5' => $followersDay5,
              'followersDay6' => $followersDay6,
              'followersDay0Comp' => $followersDay0Comp,
              'followersDay1Comp' => $followersDay1Comp,
              'followersDay2Comp' => $followersDay2Comp,
              'followersDay3Comp' => $followersDay3Comp,
              'followersDay4Comp' => $followersDay4Comp,
              'followersDay5Comp' => $followersDay5Comp,
              'followersDay6Comp' => $followersDay6Comp,
            ]
    );
  }
}
