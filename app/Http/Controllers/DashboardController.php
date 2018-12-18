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

      $postingDay0 = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, 0, convert(date, GETDATE()))');
      $postingDay1 = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -1, convert(date, GETDATE()))');
      $postingDay2 = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -2, convert(date, GETDATE()))');
      $postingDay3 = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -3, convert(date, GETDATE()))');
      $postingDay4 = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -4, convert(date, GETDATE()))');
      $postingDay5 = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -5, convert(date, GETDATE()))');
      $postingDay6 = DB::select('select count(*) as count from twitter_tweets where twitter_id = '. Auth::user()->twitterAccount->twitter_id . ' and cast(tweet_created as date) = DATEADD(day, -6, convert(date, GETDATE()))');
      $chartPosting = [$postingDay0[0]->count, $postingDay1[0]->count, $postingDay2[0]->count, $postingDay3[0]->count, $postingDay4[0]->count, $postingDay5[0]->count, $postingDay6[0]->count];

      $followersNow = DB::select('select top 1 followers_count as followers_count from twitter_accounts_log WHERE NOT (cast(created_at as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(created_at as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = '. Auth::user()->twitterAccount->twitter_id . 'order by created_at desc');
      $followersWeekAgo = DB::select('select top 1 followers_count as followers_count from twitter_accounts_log WHERE NOT (cast(created_at as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(created_at as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = '. Auth::user()->twitterAccount->twitter_id . 'order by created_at asc');
      $avgFollowers = ($followersNow[0]->followers_count - $followersWeekAgo[0]->followers_count)/7;

      $posting = DB::select('select count(tweet_id) as posting FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = '. Auth::user()->twitterAccount->twitter_id);
      $avgPosts = $posting[0]->posting/7;

      $retweet = DB::select('select SUM(retweet_count) as retweet FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = ' . Auth::user()->twitterAccount->twitter_id);
      $avgRetweets = $retweet[0]->retweet/7;

      $like = DB::select('select SUM(favorite_count) as favorite FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = ' . Auth::user()->twitterAccount->twitter_id);
      $avgLikes = $like[0]->favorite/7;

      $topTweets = DB::select('select top 5 * FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = ' . Auth::user()->twitterAccount->twitter_id . ' order by retweet_count desc ');

      $topLikes = DB::select('select top 5 * FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = ' . Auth::user()->twitterAccount->twitter_id . ' order by favorite_count desc ');

      $competitor = DB::select('select competitor_id as competitor_id from competitor where twitter_id = ' . Auth::user()->twitterAccount->twitter_id);
      $postingComp = 0;
      $retweetComp = 0;
      $likeComp = 0;
      $followersComp = 0;

      if (count($competitor) > 1) {
        for ($i=0; $i < count($competitor); $i++) {

          $followersNow = DB::select('select top 1 followers_count as followers_count from twitter_accounts_log WHERE NOT (cast(created_at as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(created_at as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = '. $competitor[$i]->competitor_id . 'order by created_at desc');
          $followersWeekAgo = DB::select('select top 1 followers_count as followers_count from twitter_accounts_log WHERE NOT (cast(created_at as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(created_at as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = '. $competitor[$i]->competitor_id . 'order by created_at asc');

          $followersComp = $followersComp + ($followersNow[0]->followers_count - $followersWeekAgo[0]->followers_count);

          $tempPost = DB::select('select count(tweet_id) as posting FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = '.$competitor[$i]->competitor_id);
          $tempRetweet = DB::select('select SUM(retweet_count) as retweet FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = ' . $competitor[$i]->competitor_id);
          $tempLike = DB::select('select SUM(favorite_count) as favorite FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = ' . $competitor[$i]->competitor_id);


          $postingComp = $postingComp + $tempPost[0]->posting;
          $retweetComp = $retweetComp + $tempRetweet[0]->retweet;
          $likeComp = $likeComp + $tempLike[0]->favorite;
        }

        $avgFollowersComp = $followersComp/7/count($competitor);
        $avgPostsComp = $postingComp/7/count($competitor);
        $avgRetweetsComp = $retweetComp/7/count($competitor);
        $avgLikesComp = $likeComp/7/count($competitor);
      } else {
        $avgPostsComp = "null";
        $avgRetweetsComp = "null";
        $avgLikesComp = "null";
        $avgFollowersComp = "null";
      }

      $recommended1 = "none";
      $alreadyTweet = DB::select('select * from twitter_tweets where cast(created_at as date) = CURRENT_TIMESTAMP and twitter_id = ' . Auth::user()->twitterAccount->twitter_id);
      // dd(!empty($alreadyTweet);
      if (empty(DB::select('select * from twitter_tweets where cast(created_at as date) = CURRENT_TIMESTAMP and twitter_id = ' . Auth::user()->twitterAccount->twitter_id))) {
        $recommended1 = "";
      }

      $temp = DB::select('select top 1 photo_url as photo_url from twitter_accounts_log where twitter_id = ' . Auth::user()->twitterAccount->twitter_id . ' order by created_at desc' );
      $photo_url = $temp[0]->photo_url;
      return view('contents.dashboard', [
        'account' => Auth::user(),
        'postingDay0' => $postingDay0,
        'postingDay1' => $postingDay1,
        'postingDay2' => $postingDay2,
        'postingDay3' => $postingDay3,
        'postingDay4' => $postingDay4,
        'postingDay5' => $postingDay5,
        'postingDay6' => $postingDay6,
        'avgFollowers' => round($avgFollowers),
        'avgPosts' => round($avgPosts),
        'avgRetweets' => round($avgRetweets),
        'avgLikes' => round($avgLikes),
        'avgFollowersComp' => round($avgFollowersComp),
        'avgPostsComp' => round($avgPostsComp),
        'avgRetweetsComp' => round($avgRetweetsComp),
        'avgLikesComp' =>round($avgLikesComp),
        'topTweets' => $topTweets,
        'topLikes' => $topLikes,
        'recommended1' => $recommended1,
        'photo_url' => $photo_url
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

  // public function dashboard()
  // {
  //   $userTweets = DB::select('select * from twitter_tweets where twitter_id = (select twitter_id from twitter_accounts where account_id = 1) and cast (tweet_created as date) >= dateadd(day,datediff(day,7,GETDATE()),0)')
  //   return view('contents.dashboard', [
  //       'account' => Auth::user(),
  //       'userTweets' => $userTweets
  //   ]);
  // }
}
