<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\TwitterAccountLog;
use App\Competitor;
use App\TwitterTweet;
use App\TwitterReply;
use Carbon\Carbon;

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
      $followersNow = TwitterAccountLog::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->orderBy('created_at', 'desc')->first();
      $followersWeekAgo = TwitterAccountLog::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->where('created_at','>=', Carbon::today()->subWeek())->first();
      $avgFollowers = ($followersNow->followers_count - $followersWeekAgo->followers_count)/8;

      $tweetsUser = TwitterTweet::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->where('created_at','>=', Carbon::today()->subWeek())->get();

      $posting = $tweetsUser->count();
      $avgPosts = $posting/8;

      $retweet = $tweetsUser->sum('retweet_count');
      $avgRetweets = $retweet/8;

      $like = $tweetsUser->sum('favorite_count');
      $avgLikes = $like/8;

      $replies = $tweetsUser->sum('replies_count');
      $avgReplies = $replies/8;

      $topTweets = TwitterTweet::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->where('created_at','>=', Carbon::today()->subWeek())->orderBy('recommendation','desc')->take(5)->get();

      $positiveTopTweet = [];
      $negativeTopTweet = [];

      foreach($topTweets as $topTweet)
      {
        $getData = TwitterReply::where('tweet_id','=',$topTweet->tweet_id)->where('sentiment','=','positif');
        array_push($positiveTopTweet,$getData->count());
        $getData = TwitterReply::where('tweet_id','=',$topTweet->tweet_id)->where('sentiment','=','negatif');
        array_push($negativeTopTweet,$getData->count());
      }

      $competitors = Competitor::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->get();
      $postingComp = 0;
      $retweetComp = 0;
      $likeComp = 0;
      $followersComp = 0;
      $repliesComp = 0;

      if (count($competitors) > 1) {
        foreach($competitors as $competitor)
        {
          $followersNow = TwitterAccountLog::where('twitter_id','=',$competitor->competitor_id)->orderBy('created_at', 'desc')->first();
          $followersWeekAgo = TwitterAccountLog::where('twitter_id','=',$competitor->competitor_id)->where('created_at','>=', Carbon::today()->subWeek())->first();
          $followersComp = $followersComp + ($followersNow->followers_count - $followersWeekAgo->followers_count);

          $tweetsComp = TwitterTweet::where('twitter_id','=',$competitor->competitor_id)->where('created_at','>=', Carbon::today()->subWeek());

          $posting = $tweetsComp->count();
          $postingComp = $postingComp + $posting;

          $retweet = $tweetsComp->sum('retweet_count');
          $retweetComp = $retweetComp + $retweet;

          $like = $tweetsComp->sum('favorite_count');
          $likeComp = $likeComp + $like;

          $replies = $tweetsComp->sum('replies_count');
          $repliesComp = $repliesComp + $replies;

        }
        $avgFollowersComp = $followersComp/8/count($competitors);
        $avgPostsComp = $postingComp/8/count($competitors);
        $avgRetweetsComp = $retweetComp/8/count($competitors);
        $avgLikesComp = $likeComp/8/count($competitors);
        $avgRepliesComp = $repliesComp/8/count($competitors);
      } else {
        $avgPostsComp = "null";
        $avgRetweetsComp = "null";
        $avgLikesComp = "null";
        $avgFollowersComp = "null";
        $avgRepliesComp = 'null';
      }

      $twitter_account_log = TwitterAccountLog::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->orderBy('created_at','desc')->first();

      $positiveSentiment = 0;
      $negativeSentiment = 0;
      $neutralSentiment = 0;

      foreach($tweetsUser as $tweetUser) {
        $getData = TwitterReply::where('tweet_id','=',$tweetUser->tweet_id)->where('sentiment','=','positif');
        $positiveSentiment = $positiveSentiment + $getData->count();

        $getData = TwitterReply::where('tweet_id','=',$tweetUser->tweet_id)->where('sentiment','=','negatif');
        $negativeSentiment = $negativeSentiment + $getData->count();

        $getData = TwitterReply::where('tweet_id','=',$tweetUser->tweet_id)->where('sentiment','=','netral');
        $neutralSentiment = $neutralSentiment + $getData->count();
      }

      $totalSentiment = $positiveSentiment + $negativeSentiment + $neutralSentiment;
      if ($totalSentiment > 0) {
        $positiveSentiment = $positiveSentiment / $totalSentiment * 100;
        $negativeSentiment = $negativeSentiment / $totalSentiment * 100;
        $neutralSentiment = $neutralSentiment / $totalSentiment * 100;
      } else {
        $postivieSentiment = 0;
        $negativeSentiment = 0;
        $neutralSentiment = 0;
      }

      if(round($avgFollowers) > round($avgFollowersComp)) {
        $insightFollowers = 1;
      } else {
        $insightFollowers = 0;
      }

      if (round($avgPosts) > round($avgPostsComp)) {
        $insightPosts = 1;
      } else {
        $insightPosts = 0;
      }

      if (round($avgRetweets) > round($avgRetweetsComp)) {
        $insightRetweets = 1;
      } else {
        $insightRetweets = 0;
      }

      if (round($avgLikes) > round($avgLikesComp)) {
        $insightLikes = 1;
      } else {
        $insightLikes = 0;
      }

      if (round($avgReplies) > round($avgRepliesComp)) {
        $insightReplies = 1;
      } else {
        $insightReplies = 0;
      }

      if (round($positiveSentiment) > round($negativeSentiment)) {
        $insightSentiment = 1;
      } else {
        $insightSentiment = 0;
      }


      $insight = $insightFollowers + $insightPosts + $insightRetweets + $insightLikes + $insightReplies + $insightSentiment;

      if ($insight > 3) {
        $insightIcon = 'far fa-smile';
        $insightText = "Aktivitas anda seminggu ini baik !";
      } else {
        $insightIcon = 'far fa-frown';
        $insightText = "Aktivitas anda seminggu ini perlu ditingkatkan !";
      }

      $recommendations = array();

      $recommendTodaysTweet = TwitterTweet::where('twitter_id','=', Auth::user()->twitterAccount->twitter_id)->whereDate('tweet_created','=',Carbon::today())->first();
      if (empty($recommendTodaysTweet)) {
        array_push($recommendations,"Posting tweet hari ini");
      }

      if ($insightPosts == 0) {
        $postRecommendation = round($avgPostsComp) - round($avgPosts) + 1;
        array_push($recommendations,"Sebaiknya hari ini anda post " . $postRecommendation . " tweet lagi");
      }
      $recommendMention = TwitterTweet::where('twitter_id','=', Auth::user()->twitterAccount->twitter_id)->whereDate('tweet_created','=',Carbon::today())->whereNotNull('reply_screen_name')->first();
      if (empty($recommendMention)) {
        array_push($recommendations,"Menanggapi mention masuk kepada anda");
      }
      $dateCreated = DB::select('select datepart(hour,tweet_created) as \'hour\', count(datepart(hour,tweet_created)) as \'count\' from ( select top 10 * from twitter_tweets  WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 0, convert(date, GETDATE()))) and twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\'  order by recommendation desc) a  group by datepart(hour,tweet_created) order by count desc');

      return view('contents.dashboard', [
        'account' => Auth::user(),
        'avgFollowers' => round($avgFollowers),
        'avgPosts' => round($avgPosts),
        'avgRetweets' => round($avgRetweets),
        'avgLikes' => round($avgLikes),
        'avgReplies' => round($avgReplies),
        'avgFollowersComp' => round($avgFollowersComp),
        'avgPostsComp' => round($avgPostsComp),
        'avgRetweetsComp' => round($avgRetweetsComp),
        'avgLikesComp' =>round($avgLikesComp),
        'avgRepliesComp' => round($avgRepliesComp),
        'topTweets' => $topTweets,
        'positiveTopTweet' => $positiveTopTweet,
        'negativeTopTweet' => $negativeTopTweet,
        'recommendations' => $recommendations,
        'twitter_account_log' => $twitter_account_log,
        'positiveSentiment' => round($positiveSentiment,2),
        'negativeSentiment' => round($negativeSentiment,2),
        'neutralSentiment' => round($neutralSentiment,2),
        'totalSentiment' => $totalSentiment,
        'insightIcon' => $insightIcon,
        'insightText' => $insightText,
        'dateCreated' => $dateCreated
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
