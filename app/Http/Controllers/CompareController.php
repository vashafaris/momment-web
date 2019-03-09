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
    $competitorTemp = DB::select('select competitor_id as competitor_id from competitor where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id .'\'');
    for ($i=0; $i < count($competitorTemp); $i++) {
       $temp = DB::select('select top 1 * from twitter_accounts_log where twitter_id = \'' . $competitorTemp[$i]->competitor_id . '\' order by created_at desc');
       $competitors[$i] = $temp[0];
    }
    return view('contents.competitor', [
      'account' => Auth::user(),
      'competitors' => $competitors
    ]);
  }

  public function compare($id)
  {
    $competitorTemp = DB::select('select * from twitter_accounts_log where twitter_id = \'' . $id . '\'');
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
    $isCompetitor = false;
    $id = Auth::user()->id;
    $twitter_id =  DB::select('select distinct twitter_id from twitter_accounts where account_id = ' . $id);
    $check = DB::select('select * from competitor where twitter_id = \'' . $twitter_id[0]->twitter_id . '\' and competitor_id = \'' . $result[0]->user_id . '\'');
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

    $userTwitterID = DB::select('select twitter_id from twitter_accounts where account_id = \'' . Auth::user()->id . '\'');
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

  public function deleteAccount($idCompetitor)
  {
    $id = Auth::user()->id;
    $twitter_id =  DB::select('select distinct twitter_id from twitter_accounts where account_id = ' . $id);
    if($delete = DB::table('competitor')->where([
      'twitter_id' => $twitter_id[0]->twitter_id,
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
    $accountData = DB::select('select top 1 * from twitter_accounts_log where twitter_id = \'' . $id . '\' order by created_at desc');

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
    $accountData = DB::select('select top 1 * from twitter_accounts_log where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' order by created_at desc');
    $accountDataComp = DB::select('select top 1 * from twitter_accounts_log where twitter_id = \'' . $id . '\' order by created_at desc');

    $followersNow = DB::select('select top 1 followers_count as followers_count from twitter_accounts_log WHERE NOT (cast(created_at as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(created_at as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' order by created_at desc');
    $followersWeekAgo = DB::select('select top 1 followers_count as followers_count from twitter_accounts_log WHERE NOT (cast(created_at as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(created_at as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' order by created_at asc');
    $followers = ($followersNow[0]->followers_count - $followersWeekAgo[0]->followers_count);

    $posting = DB::select('select count(tweet_id) as posting FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\'');
    $posts = $posting[0]->posting;

    $retweet = DB::select('select SUM(retweet_count) as retweet FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\'');
    $retweets = $retweet[0]->retweet;

    $like = DB::select('select SUM(favorite_count) as favorite FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\'');
    $likes = $like[0]->favorite;

    $followersNow = DB::select('select top 1 followers_count as followers_count from twitter_accounts_log WHERE NOT (cast(created_at as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(created_at as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \''. $id . '\' order by created_at desc');
    $followersWeekAgo = DB::select('select top 1 followers_count as followers_count from twitter_accounts_log WHERE NOT (cast(created_at as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(created_at as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \''. $id . '\' order by created_at asc');
    $followersComp = ($followersNow[0]->followers_count - $followersWeekAgo[0]->followers_count);

    $posting = DB::select('select count(tweet_id) as posting FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \''. $id . '\'');
    $postsComp = $posting[0]->posting;

    $retweet = DB::select('select SUM(retweet_count) as retweet FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \'' . $id . '\'');
    $retweetsComp = $retweet[0]->retweet;

    $like = DB::select('select SUM(favorite_count) as favorite FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \'' . $id . '\'');
    $likesComp = $like[0]->favorite;

    $replies = DB::select('select SUM(replies_count) as replies from twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\'');
    $replies = $replies[0]->replies;

    $repliesComp = DB::select('select SUM(replies_count) as replies from twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \'' . $id . '\'');
    $repliesComp = $repliesComp[0]->replies;

    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' and cast(created_at as date) = DATEADD(day, 0, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' and cast(created_at as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay0 = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay0 = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' and cast(created_at as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' and cast(created_at as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay1 = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay1 = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' and cast(created_at as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' and cast(created_at as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay2 = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay2 = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' and cast(created_at as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' and cast(created_at as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay3 = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay3 = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' and cast(created_at as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' and cast(created_at as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay4 = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay4 = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' and cast(created_at as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' and cast(created_at as date) = DATEADD(day, -6, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay5 = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay5 = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' and cast(created_at as date) = DATEADD(day, -6, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' and cast(created_at as date) = DATEADD(day, -7, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay6 = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay6 = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' and cast(created_at as date) = DATEADD(day, -7, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' and cast(created_at as date) = DATEADD(day, -8, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay7 = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay7 = 0;
    }

    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . $id . '\' and cast(created_at as date) = DATEADD(day, 0, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . $id . '\' and cast(created_at as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay0Comp = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay0Comp = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . $id . '\' and cast(created_at as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . $id . '\' and cast(created_at as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay1Comp = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay1Comp = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . $id . '\' and cast(created_at as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . $id . '\' and cast(created_at as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay2Comp = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay2Comp = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . $id . '\' and cast(created_at as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . $id . '\' and cast(created_at as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay3Comp = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay3Comp = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . $id . '\' and cast(created_at as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . $id . '\' and cast(created_at as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay4Comp = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay4Comp = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . $id . '\' and cast(created_at as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . $id . '\' and cast(created_at as date) = DATEADD(day, -6, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay5Comp = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay5Comp = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' .$id . '\' and cast(created_at as date) = DATEADD(day, -6, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . $id . '\' and cast(created_at as date) = DATEADD(day, -7, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay6Comp = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay6Comp = 0;
    }
    $tempFollowers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' .$id . '\' and cast(created_at as date) = DATEADD(day, -7, convert(date, GETDATE()))');
    $temp2Followers =  DB::select('select followers_count as followers_count from twitter_accounts_log where twitter_id = \'' . $id . '\' and cast(created_at as date) = DATEADD(day, -8, convert(date, GETDATE()))');
    if (!empty($tempFollowers[0]->followers_count) && !empty($temp2Followers[0]->followers_count)){
        $followersDay7Comp = $tempFollowers[0]->followers_count - $temp2Followers[0]->followers_count;
    } else {
      $followersDay7Comp = 0;
    }

    $postingDay0 = DB::select('select count(*) as count from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, 0, convert(date, GETDATE()))');
    $postingDay1 = DB::select('select count(*) as count from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    $postingDay2 = DB::select('select count(*) as count from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    $postingDay3 = DB::select('select count(*) as count from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    $postingDay4 = DB::select('select count(*) as count from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    $postingDay5 = DB::select('select count(*) as count from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    $postingDay6 = DB::select('select count(*) as count from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -6, convert(date, GETDATE()))');
    $postingDay7 = DB::select('select count(*) as count from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -7, convert(date, GETDATE()))');

    if (empty($postingDay0[0]->count)) {
      $postingDay0 = 0;
    } else {
      $postingDay0 = $postingDay0[0]->count;
    }
    if (empty($postingDay1[0]->count)) {
      $postingDay1 = 0;
    } else {
      $postingDay1 = $postingDay1[0]->count;
    }
    if (empty($postingDay2[0]->count)) {
      $postingDay2 = 0;
    } else {
      $postingDay2 = $postingDay2[0]->count;
    }
    if (empty($postingDay3[0]->count)) {
      $postingDay3 = 0;
    } else {
      $postingDay3 = $postingDay3[0]->count;
    }
      $postingDay4 = 0;
      if (empty($postingDay4[0]->count)) {
    } else {
      $postingDay4 = $postingDay4[0]->count;
    }
    if (empty($postingDay5[0]->count)) {
      $postingDay5 = 0;
    } else {
      $postingDay5 = $postingDay5[0]->count;
    }
    if (empty($postingDay6[0]->count)) {
      $postingDay6 = 0;
    } else {
      $postingDay6 = $postingDay6[0]->count;
    }
    if (empty($postingDay7[0]->count)) {
      $postingDay7 = 0;
    } else {
      $postingDay7 = $postingDay7[0]->count;
    }



    $postingDay0Comp = DB::select('select count(*) as count from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, 0, convert(date, GETDATE()))');
    $postingDay1Comp = DB::select('select count(*) as count from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    $postingDay2Comp = DB::select('select count(*) as count from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    $postingDay3Comp = DB::select('select count(*) as count from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    $postingDay4Comp = DB::select('select count(*) as count from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    $postingDay5Comp = DB::select('select count(*) as count from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    $postingDay6Comp = DB::select('select count(*) as count from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -6, convert(date, GETDATE()))');
    $postingDay7Comp = DB::select('select count(*) as count from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -7, convert(date, GETDATE()))');

    if (empty($postingDay0Comp[0]->count)) {
      $postingDay0Comp = 0;
    } else {
      $postingDay0Comp = $postingDay0Comp[0]->count;
    }
    if (empty($postingDay1Comp[0]->count)) {
      $postingDay1Comp = 0;
    } else {
      $postingDay1Comp = $postingDay1Comp[0]->count;
    }
    if (empty($postingDay2Comp[0]->count)) {
      $postingDay2Comp = 0;
    } else {
      $postingDay2Comp = $postingDay2Comp[0]->count;
    }
    if (empty($postingDay3Comp[0]->count)) {
      $postingDay3Comp = 0;
    } else {
      $postingDay3Comp = $postingDay3Comp[0]->count;
    }
      $postingDay4Comp = 0;
      if (empty($postingDay4Comp[0]->count)) {
    } else {
      $postingDay4Comp = $postingDay4Comp[0]->count;
    }
    if (empty($postingDay5Comp[0]->count)) {
      $postingDay5Comp = 0;
    } else {
      $postingDay5Comp = $postingDay5Comp[0]->count;
    }
    if (empty($postingDay6Comp[0]->count)) {
      $postingDay6Comp = 0;
    } else {
      $postingDay6Comp = $postingDay6Comp[0]->count;
    }
    if (empty($postingDay7Comp[0]->count)) {
      $postingDay7Comp = 0;
    } else {
      $postingDay7Comp = $postingDay7Comp[0]->count;
    }

    $retweetDay0 = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, 0, convert(date, GETDATE()))');
    $retweetDay1 = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    $retweetDay2 = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    $retweetDay3 = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    $retweetDay4 = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    $retweetDay5 = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    $retweetDay6 = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -6, convert(date, GETDATE()))');
    $retweetDay7 = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -7, convert(date, GETDATE()))');

    if (empty($retweetDay0[0]->retweet)) {
      $retweetDay0 = 0;
    } else {
      $retweetDay0 = $retweetDay0[0]->retweet;
    }
    if (empty($retweetDay1[0]->retweet)) {
      $retweetDay1 = 0;
    } else {
      $retweetDay1 = $retweetDay1[0]->retweet;
    }
    if (empty($retweetDay2[0]->retweet)) {
      $retweetDay2 = 0;
    } else {
      $retweetDay2 = $retweetDay2[0]->retweet;
    }
    if (empty($retweetDay3[0]->retweet)) {
      $retweetDay3 = 0;
    } else {
      $retweetDay3 = $retweetDay3[0]->retweet;
    }
      $retweetDay4 = 0;
      if (empty($retweetDay4[0]->retweet)) {
    } else {
      $retweetDay4 = $retweetDay4[0]->retweet;
    }
    if (empty($retweetDay5[0]->retweet)) {
      $retweetDay5 = 0;
    } else {
      $retweetDay5 = $retweetDay5[0]->retweet;
    }
    if (empty($retweetDay6[0]->retweet)) {
      $retweetDay6 = 0;
    } else {
      $retweetDay6 = $retweetDay6[0]->retweet;
    }
    if (empty($retweetDay7[0]->retweet)) {
      $retweetDay7 = 0;
    } else {
      $retweetDay7 = $retweetDay7[0]->retweet;
    }

    $retweetDay0Comp = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, 0, convert(date, GETDATE()))');
    $retweetDay1Comp = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    $retweetDay2Comp = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    $retweetDay3Comp = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    $retweetDay4Comp = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    $retweetDay5Comp = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    $retweetDay6Comp = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -6, convert(date, GETDATE()))');
    $retweetDay7Comp = DB::select('select SUM(retweet_count) as retweet from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -7, convert(date, GETDATE()))');

    if (empty($retweetDay0Comp[0]->retweet)) {
      $retweetDay0Comp = 0;
    } else {
      $retweetDay0Comp = $retweetDay0Comp[0]->retweet;
    }
    if (empty($retweetDay1Comp[0]->retweet)) {
      $retweetDay1Comp = 0;
    } else {
      $retweetDay1Comp = $retweetDay1Comp[0]->retweet;
    }
    if (empty($retweetDay2Comp[0]->retweet)) {
      $retweetDay2Comp = 0;
    } else {
      $retweetDay2Comp = $retweetDay2Comp[0]->retweet;
    }
    if (empty($retweetDay3Comp[0]->retweet)) {
      $retweetDay3Comp = 0;
    } else {
      $retweetDay3Comp = $retweetDay3Comp[0]->retweet;
    }
      $retweetDay4Comp = 0;
      if (empty($retweetDay4Comp[0]->retweet)) {
    } else {
      $retweetDay4Comp = $retweetDay4Comp[0]->retweet;
    }
    if (empty($retweetDay5Comp[0]->retweet)) {
      $retweetDay5Comp = 0;
    } else {
      $retweetDay5Comp = $retweetDay5Comp[0]->retweet;
    }
    if (empty($retweetDay6Comp[0]->retweet)) {
      $retweetDay6Comp = 0;
    } else {
      $retweetDay6Comp = $retweetDay6Comp[0]->retweet;
    }
    if (empty($retweetDay7Comp[0]->retweet)) {
      $retweetDay7Comp = 0;
    } else {
      $retweetDay7Comp = $retweetDay7Comp[0]->retweet;
    }

    $likesDay0 = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, 0, convert(date, GETDATE()))');
    $likesDay1 = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    $likesDay2 = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    $likesDay3 = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    $likesDay4 = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    $likesDay5 = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    $likesDay6 = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -6, convert(date, GETDATE()))');
    $likesDay7 =  DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -7, convert(date, GETDATE()))');

    if (empty($likesDay0[0]->favorite)) {
      $likesDay0 = 0;
    }else {
      $likesDay0 = $likesDay0[0]->favorite;
    }

    if (empty($likesDay1[0]->favorite)) {
      $likesDay1 = 0;
    }else {
      $likesDay1 = $likesDay1[0]->favorite;
    }

    if (empty($likesDay2[0]->favorite)) {
      $likesDay2 = 0;
    }else {
      $likesDay2 = $likesDay2[0]->favorite;
    }

    if (empty($likesDay3[0]->favorite)) {
      $likesDay3 = 0;
    }else {
      $likesDay3 = $likesDay3[0]->favorite;
    }

    if (empty($likesDay4[0]->favorite)) {
      $likesDay4 = 0;
    }else {
      $likesDay4 = $likesDay4[0]->favorite;
    }

    if (empty($likesDay5[0]->favorite)) {
      $likesDay5 = 0;
    }else {
      $likesDay5 = $likesDay5[0]->favorite;
    }

    if (empty($likesDay6[0]->favorite)) {
      $likesDay6 = 0;
    }else {
      $likesDay6 = $likesDay6[0]->favorite;
    }

    if (empty($likesDay7[0]->favorite)) {
      $likesDay7 = 0;
    }else {
      $likesDay7 = $likesDay7[0]->favorite;
    }

    $likesDay0Comp = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, 0, convert(date, GETDATE()))');
    $likesDay1Comp = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    $likesDay2Comp = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    $likesDay3Comp = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    $likesDay4Comp = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    $likesDay5Comp = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    $likesDay6Comp = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -6, convert(date, GETDATE()))');
    $likesDay7Comp = DB::select('select SUM(favorite_count) as favorite from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -7, convert(date, GETDATE()))');

    if (empty($likesDay0Comp[0]->favorite)) {
      $likesDay0Comp = 0;
    }else {
      $likesDay0Comp = $likesDay0Comp[0]->favorite;
    }

    if (empty($likesDay1Comp[0]->favorite)) {
      $likesDay1Comp = 0;
    }else {
      $likesDay1Comp = $likesDay1Comp[0]->favorite;
    }

    if (empty($likesDay2Comp[0]->favorite)) {
      $likesDay2Comp = 0;
    }else {
      $likesDay2Comp = $likesDay2Comp[0]->favorite;
    }

    if (empty($likesDay3Comp[0]->favorite)) {
      $likesDay3Comp = 0;
    }else {
      $likesDay3Comp = $likesDay3Comp[0]->favorite;
    }

    if (empty($likesDay4Comp[0]->favorite)) {
      $likesDay4Comp = 0;
    }else {
      $likesDay4Comp = $likesDay4Comp[0]->favorite;
    }

    if (empty($likesDay5Comp[0]->favorite)) {
      $likesDay5Comp = 0;
    }else {
      $likesDay5Comp = $likesDay5Comp[0]->favorite;
    }

    if (empty($likesDay6Comp[0]->favorite)) {
      $likesDay6Comp = 0;
    }else {
      $likesDay6Comp = $likesDay6Comp[0]->favorite;
    }

    if (empty($likesDay7Comp[0]->favorite)) {
      $likesDay7Comp = 0;
    }else {
      $likesDay7Comp = $likesDay7Comp[0]->favorite;
    }

    $repliesDay0 = DB::select('select SUM(replies_count) as replies from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, 0, convert(date, GETDATE()))');
    $repliesDay1 = DB::select('select SUM(replies_count) as replies from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    $repliesDay2 = DB::select('select SUM(replies_count) as replies from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    $repliesDay3 = DB::select('select SUM(replies_count) as replies from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    $repliesDay4 = DB::select('select SUM(replies_count) as replies from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    $repliesDay5 = DB::select('select SUM(replies_count) as replies from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    $repliesDay6 = DB::select('select SUM(replies_count) as replies from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -6, convert(date, GETDATE()))');
    $repliesDay7 = DB::select('select SUM(replies_count) as replies from twitter_tweets where twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' and cast(tweet_created as date) = DATEADD(day, -7, convert(date, GETDATE()))');

    if (empty($repliesDay0[0]->replies)) {
      $repliesDay0 = 0;
    }else {
      $repliesDay0 = $repliesDay0[0]->replies;
    }

    if (empty($repliesDay1[0]->replies)) {
      $repliesDay1 = 0;
    }else {
      $repliesDay1 = $repliesDay1[0]->replies;
    }

    if (empty($repliesDay2[0]->replies)) {
      $repliesDay2 = 0;
    }else {
      $repliesDay2 = $repliesDay2[0]->replies;
    }

    if (empty($repliesDay3[0]->replies)) {
      $repliesDay3 = 0;
    }else {
      $repliesDay3 = $repliesDay3[0]->replies;
    }

    if (empty($repliesDay4[0]->replies)) {
      $repliesDay4 = 0;
    }else {
      $repliesDay4 = $repliesDay4[0]->replies;
    }

    if (empty($repliesDay5[0]->replies)) {
      $repliesDay5 = 0;
    }else {
      $repliesDay5 = $repliesDay5[0]->replies;
    }

    if (empty($repliesDay6[0]->replies)) {
      $repliesDay6 = 0;
    }else {
      $repliesDay6 = $repliesDay6[0]->replies;
    }

    if (empty($repliesDay7[0]->replies)) {
      $repliesDay7 = 0;
    }else {
      $repliesDay7 = $repliesDay7[0]->replies;
    }

    $repliesDay0Comp = DB::select('select SUM(replies_count) as replies from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, 0, convert(date, GETDATE()))');
    $repliesDay1Comp = DB::select('select SUM(replies_count) as replies from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -1, convert(date, GETDATE()))');
    $repliesDay2Comp = DB::select('select SUM(replies_count) as replies from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -2, convert(date, GETDATE()))');
    $repliesDay3Comp = DB::select('select SUM(replies_count) as replies from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -3, convert(date, GETDATE()))');
    $repliesDay4Comp = DB::select('select SUM(replies_count) as replies from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -4, convert(date, GETDATE()))');
    $repliesDay5Comp = DB::select('select SUM(replies_count) as replies from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -5, convert(date, GETDATE()))');
    $repliesDay6Comp = DB::select('select SUM(replies_count) as replies from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -6, convert(date, GETDATE()))');
    $repliesDay7Comp = DB::select('select SUM(replies_count) as replies from twitter_tweets where twitter_id = \''. $id . '\' and cast(tweet_created as date) = DATEADD(day, -7, convert(date, GETDATE()))');

    if (empty($repliesDay0Comp[0]->replies)) {
      $repliesDay0Comp = 0;
    }else {
      $repliesDay0Comp = $repliesDay0Comp[0]->replies;
    }

    if (empty($repliesDay1Comp[0]->replies)) {
      $repliesDay1Comp = 0;
    }else {
      $repliesDay1Comp = $repliesDay1Comp[0]->replies;
    }

    if (empty($repliesDay2Comp[0]->replies)) {
      $repliesDay2Comp = 0;
    }else {
      $repliesDay2Comp = $repliesDay2Comp[0]->replies;
    }

    if (empty($repliesDay3Comp[0]->replies)) {
      $repliesDay3Comp = 0;
    }else {
      $repliesDay3Comp = $repliesDay3Comp[0]->replies;
    }

    if (empty($repliesDay4Comp[0]->replies)) {
      $repliesDay4Comp = 0;
    }else {
      $repliesDay4Comp = $repliesDay4Comp[0]->replies;
    }

    if (empty($repliesDay5Comp[0]->replies)) {
      $repliesDay5Comp = 0;
    }else {
      $repliesDay5Comp = $repliesDay5Comp[0]->replies;
    }

    if (empty($repliesDay6Comp[0]->replies)) {
      $repliesDay6Comp = 0;
    }else {
      $repliesDay6Comp = $repliesDay6Comp[0]->replies;
    }

    if (empty($repliesDay7Comp[0]->replies)) {
      $repliesDay7Comp = 0;
    }else {
      $repliesDay7Comp = $repliesDay7Comp[0]->replies;
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
              'postingDay0' => $postingDay0,
              'postingDay1' => $postingDay1,
              'postingDay2' => $postingDay2,
              'postingDay3' => $postingDay3,
              'postingDay4' => $postingDay4,
              'postingDay5' => $postingDay5,
              'postingDay6' => $postingDay6,
              'postingDay7' => $postingDay7,
              'postingDay0Comp' => $postingDay0Comp,
              'postingDay1Comp' => $postingDay1Comp,
              'postingDay2Comp' => $postingDay2Comp,
              'postingDay3Comp' => $postingDay3Comp,
              'postingDay4Comp' => $postingDay4Comp,
              'postingDay5Comp' => $postingDay5Comp,
              'postingDay6Comp' => $postingDay6Comp,
              'postingDay7Comp' => $postingDay7Comp,
              'retweetDay0' => $retweetDay0,
              'retweetDay1' => $retweetDay1,
              'retweetDay2' => $retweetDay2,
              'retweetDay3' => $retweetDay3,
              'retweetDay4' => $retweetDay4,
              'retweetDay5' => $retweetDay5,
              'retweetDay6' => $retweetDay6,
              'retweetDay7' => $retweetDay7,
              'retweetDay0Comp' => $retweetDay0Comp,
              'retweetDay1Comp' => $retweetDay1Comp,
              'retweetDay2Comp' => $retweetDay2Comp,
              'retweetDay3Comp' => $retweetDay3Comp,
              'retweetDay4Comp' => $retweetDay4Comp,
              'retweetDay5Comp' => $retweetDay5Comp,
              'retweetDay6Comp' => $retweetDay6Comp,
              'retweetDay7Comp' => $retweetDay7Comp,
              'likesDay0' => $likesDay0,
              'likesDay1' => $likesDay1,
              'likesDay2' => $likesDay2,
              'likesDay3' => $likesDay3,
              'likesDay4' => $likesDay4,
              'likesDay5' => $likesDay5,
              'likesDay6' => $likesDay6,
              'likesDay7' => $likesDay7,
              'likesDay0Comp' => $likesDay0Comp,
              'likesDay1Comp' => $likesDay1Comp,
              'likesDay2Comp' => $likesDay2Comp,
              'likesDay3Comp' => $likesDay3Comp,
              'likesDay4Comp' => $likesDay4Comp,
              'likesDay5Comp' => $likesDay5Comp,
              'likesDay6Comp' => $likesDay6Comp,
              'likesDay7Comp' => $likesDay7Comp,
              'followersDay0' => $followersDay0,
              'followersDay1' => $followersDay1,
              'followersDay2' => $followersDay2,
              'followersDay3' => $followersDay3,
              'followersDay4' => $followersDay4,
              'followersDay5' => $followersDay5,
              'followersDay6' => $followersDay6,
              'followersDay7' => $followersDay7,
              'followersDay0Comp' => $followersDay0Comp,
              'followersDay1Comp' => $followersDay1Comp,
              'followersDay2Comp' => $followersDay2Comp,
              'followersDay3Comp' => $followersDay3Comp,
              'followersDay4Comp' => $followersDay4Comp,
              'followersDay5Comp' => $followersDay5Comp,
              'followersDay6Comp' => $followersDay6Comp,
              'followersDay7Comp' => $followersDay7Comp,
              'repliesDay0' => $repliesDay0,
              'repliesDay1' => $repliesDay1,
              'repliesDay2' => $repliesDay2,
              'repliesDay3' => $repliesDay3,
              'repliesDay4' => $repliesDay4,
              'repliesDay5' => $repliesDay5,
              'repliesDay6' => $repliesDay6,
              'repliesDay7' => $repliesDay7,
              'repliesDay0Comp' => $repliesDay0Comp,
              'repliesDay1Comp' => $repliesDay1Comp,
              'repliesDay2Comp' => $repliesDay2Comp,
              'repliesDay3Comp' => $repliesDay3Comp,
              'repliesDay4Comp' => $repliesDay4Comp,
              'repliesDay5Comp' => $repliesDay5Comp,
              'repliesDay6Comp' => $repliesDay6Comp,
              'repliesDay7Comp' => $repliesDay7Comp

            ]
    );
  }
}
