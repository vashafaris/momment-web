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
      $followersNow = DB::select('select top 1 followers_count as followers_count from twitter_accounts_log WHERE NOT (cast(created_at as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(created_at as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' order by created_at desc');
      $followersWeekAgo = DB::select('select top 1 followers_count as followers_count from twitter_accounts_log WHERE NOT (cast(created_at as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(created_at as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\' order by created_at asc');
      $avgFollowers = ($followersNow[0]->followers_count - $followersWeekAgo[0]->followers_count)/7;

      $posting = DB::select('select count(tweet_id) as posting FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \''. Auth::user()->twitterAccount->twitter_id . '\'');
      $avgPosts = $posting[0]->posting/7;

      $retweet = DB::select('select SUM(retweet_count) as retweet FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\'');
      $avgRetweets = $retweet[0]->retweet/7;

      $like = DB::select('select SUM(favorite_count) as favorite FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\'');
      $avgLikes = $like[0]->favorite/7;

      $topTweets = DB::select('select top 5 * FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' order by recommendation desc ');
      //
      // $topTweets = shell_exec("python D:\wp3.py");
      // dd($topTweets);

      $competitor = DB::select('select competitor_id as competitor_id from competitor where twitter_id = ' . Auth::user()->twitterAccount->twitter_id);
      $postingComp = 0;
      $retweetComp = 0;
      $likeComp = 0;
      $followersComp = 0;

      if (count($competitor) > 1) {
        for ($i=0; $i < count($competitor); $i++) {

          $followersNow = DB::select('select top 1 followers_count as followers_count from twitter_accounts_log WHERE NOT (cast(created_at as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(created_at as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \''. $competitor[$i]->competitor_id . '\' order by created_at desc');
          $followersWeekAgo = DB::select('select top 1 followers_count as followers_count from twitter_accounts_log WHERE NOT (cast(created_at as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(created_at as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \''. $competitor[$i]->competitor_id . '\' order by created_at asc');

          $followersComp = $followersComp + ($followersNow[0]->followers_count - $followersWeekAgo[0]->followers_count);

          $tempPost = DB::select('select count(tweet_id) as posting FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \''.$competitor[$i]->competitor_id . '\'');
          $tempRetweet = DB::select('select SUM(retweet_count) as retweet FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \'' . $competitor[$i]->competitor_id . '\'');
          $tempLike = DB::select('select SUM(favorite_count) as favorite FROM twitter_tweets WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 1, convert(date, GETDATE()))) and twitter_id = \'' . $competitor[$i]->competitor_id . '\'');


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
      $alreadyTweet = DB::select('select * from twitter_tweets where cast(created_at as date) = CURRENT_TIMESTAMP and twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\'');
      // dd(!empty($alreadyTweet);
      if (empty(DB::select('select * from twitter_tweets where cast(created_at as date) = CURRENT_TIMESTAMP and twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\''))) {
        $recommended1 = "";
      }

      $temp = DB::select('select top 1 * from twitter_accounts_log where twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\' order by created_at desc' );
      $twitter_account_log = $temp[0];

      $positiveSentiment = DB::select(' select count(twitter_replies.replies_id) as count from twitter_replies join twitter_tweets on twitter_replies.tweet_id = twitter_tweets.tweet_id where twitter_id = \''. Auth::user()->twitterAccount->twitter_id .'\'  and twitter_replies.sentiment = \'positif\'');
      $negativeSentiment = DB::select(' select count(twitter_replies.replies_id) as count from twitter_replies join twitter_tweets on twitter_replies.tweet_id = twitter_tweets.tweet_id where twitter_id = \''. Auth::user()->twitterAccount->twitter_id .'\'  and twitter_replies.sentiment = \'negatif\'');
      $neutralSentiment = DB::select(' select count(twitter_replies.replies_id) as count from twitter_replies join twitter_tweets on twitter_replies.tweet_id = twitter_tweets.tweet_id where twitter_id = \''. Auth::user()->twitterAccount->twitter_id .'\'  and twitter_replies.sentiment = \'netral\'');

      $totalSentiment = $positiveSentiment[0]->count + $negativeSentiment[0]->count + $neutralSentiment[0]->count;
      if ($totalSentiment > 0) {
        $positiveSentiment = $positiveSentiment[0]->count / $totalSentiment * 100;
        $negativeSentiment = $negativeSentiment[0]->count / $totalSentiment * 100;
        $neutralSentiment = $neutralSentiment[0]->count / $totalSentiment * 100;
      } else {
        $postivieSentiment = 0;
        $negativeSentiment = 0;
        $neutralSentiment = 0;
      }

      if($avgFollowers > $avgFollowersComp) {
        $insightFollowers = 1;
      } else {
        $insightFollowers = 0;
      }

      if ($avgPosts > $avgFollowersComp) {
        $insightPosts = 1;
      } else {
        $insightPosts = 0;
      }

      if ($avgRetweets > $avgRetweetsComp) {
        $insightRetweets = 1;
      } else {
        $insightRetweets = 0;
      }

      if ($avgLikes > $avgLikesComp) {
        $insightLikes = 1;
      } else {
        $insightLikes = 0;
      }

      if ($positiveSentiment > $negativeSentiment) {
        $insightSentiment = 1;
      } else {
        $insightSentiment = 0;
      }

      $insight = $insightFollowers + $insightPosts + $insightRetweets + $insightLikes + $insightSentiment;

      if ($insight >= 3) {
        $insightIcon = 'far fa-smile';
        $insightText = "Aktivitas anda pada minggu ini baik !";
      } else {
        $insightIcon = 'far fa-frown';
        $insightText = "Aktivitas anda pada minggu ini perlu ditingkatkan !";
      }


      return view('contents.dashboard', [
        'account' => Auth::user(),
        'avgFollowers' => round($avgFollowers),
        'avgPosts' => round($avgPosts),
        'avgRetweets' => round($avgRetweets),
        'avgLikes' => round($avgLikes),
        'avgFollowersComp' => round($avgFollowersComp),
        'avgPostsComp' => round($avgPostsComp),
        'avgRetweetsComp' => round($avgRetweetsComp),
        'avgLikesComp' =>round($avgLikesComp),
        'topTweets' => $topTweets,
        'recommended1' => $recommended1,
        'twitter_account_log' => $twitter_account_log,
        'positiveSentiment' => round($positiveSentiment,2),
        'negativeSentiment' => round($negativeSentiment,2),
        'neutralSentiment' => round($neutralSentiment,2),
        'totalSentiment' => $totalSentiment,
        'insightIcon' => $insightIcon,
        'insightText' => $insightText
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
