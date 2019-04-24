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
      return view('contents.dashboard', [
        'account' => Auth::user(),
      ]);
    }
  }

  public function showProfile()
  {
    $accountData = TwitterAccountLog::where('twitter_id',Auth::user()->twitterAccount->twitter_id)->orderBy('created_at','desc')->first();
    $accountData['description'] = mb_convert_encoding($accountData['description'], 'UTF-8', 'UTF-8');
    return response()->json(
            [
              'status' => 200,
              'message' => 'success',
              'response' => $accountData
            ]
    );
  }

  public function showFollowers()
  {
    $followersNowUser = TwitterAccountLog::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->orderBy('created_at', 'desc')->first();
    $followersWeekAgoUser = TwitterAccountLog::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->where('created_at','>=', Carbon::today()->subWeek())->first();
    $competitors = Competitor::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->get();
    $avgFollowers = ($followersNowUser->followers_count - $followersWeekAgoUser->followers_count)/8;
    $avgFollowers = round($avgFollowers);
    $followersComp = 0;
    if (count($competitors) > 1) {
      foreach($competitors as $competitor)
      {
        $followersNowComp = TwitterAccountLog::where('twitter_id','=',$competitor->competitor_id)->orderBy('created_at', 'desc')->first();
        $followersWeekAgoComp = TwitterAccountLog::where('twitter_id','=',$competitor->competitor_id)->where('created_at','>=', Carbon::today()->subWeek())->first();

        $followersComp = $followersComp + ($followersNowComp->followers_count - $followersWeekAgoComp->followers_count);
      }
      $avgFollowersComp = $followersComp/8/count($competitors);
      $avgFollowersComp = round($avgFollowersComp);
    } else {
      $avgFollowersComp = "null";
    }
    return response()->json(
            [
              'status' => 200,
              'message' => 'success',
              'response' => [
                'avgFollowers' => $avgFollowers,
                'avgFollowersComp' => $avgFollowersComp
              ]
            ]
    );
  }

  public function showPosting()
  {
    $tweetsUser = TwitterTweet::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->where('created_at','>=', Carbon::today()->subWeek())->get();
    $competitors = Competitor::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->get();

    $postingComp = 0;
    if (count($competitors) > 1) {
      foreach($competitors as $competitor)
      {
        $tweetsComp = TwitterTweet::where('twitter_id','=',$competitor->competitor_id)->where('created_at','>=', Carbon::today()->subWeek());

        $posting = $tweetsComp->count();
        $postingComp = $postingComp + $posting;
      }
      $avgPostsComp = $postingComp/8/count($competitors);
      $avgPostsComp = round($avgPostsComp);
    } else {
      $avgPostsComp = "null";
    }
    $posting = $tweetsUser->count();
    $avgPosts = $posting/8;
    $avgPosts = round($avgPosts);

    return response()->json(
            [
              'status' => 200,
              'message' => 'success',
              'response' => [
                'avgPosts' => $avgPosts,
                'avgPostsComp' => $avgPostsComp
              ]
            ]
    );
  }

  public function showRetweet()
  {
    $tweetsUser = TwitterTweet::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->where('created_at','>=', Carbon::today()->subWeek())->get();
    $competitors = Competitor::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->get();

    $retweetsComp = 0;
    if (count($competitors) > 1) {
      foreach($competitors as $competitor)
      {
        $tweetsComp = TwitterTweet::where('twitter_id','=',$competitor->competitor_id)->where('created_at','>=', Carbon::today()->subWeek());

        $retweets = $tweetsComp->sum('retweet_count');
        $retweetsComp = $retweetsComp + $retweets;
      }
      $avgRetweetsComp = $retweetsComp/8/count($competitors);
      $avgRetweetsComp = round($avgRetweetsComp);
    } else {
      $avgRetweetsComp = "null";
    }
    $retweets = $tweetsUser->sum('retweet_count');
    $avgRetweets = $retweets/8;
    $avgRetweets = round($avgRetweets);

    return response()->json(
            [
              'status' => 200,
              'message' => 'success',
              'response' => [
                'avgRetweets' => $avgRetweets,
                'avgRetweetsComp' => $avgRetweetsComp
              ]
            ]
    );
  }

  public function showLikes()
  {
    $tweetsUser = TwitterTweet::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->where('created_at','>=', Carbon::today()->subWeek())->get();
    $competitors = Competitor::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->get();

    $likesComp = 0;
    if (count($competitors) > 1) {
      foreach($competitors as $competitor)
      {
        $tweetsComp = TwitterTweet::where('twitter_id','=',$competitor->competitor_id)->where('created_at','>=', Carbon::today()->subWeek());

        $likes = $tweetsComp->sum('favorite_count');
        $likesComp = $likesComp + $likes;
      }
      $avgLikesComp = $likesComp/8/count($competitors);
      $avgLikesComp = round($avgLikesComp);
    } else {
      $avgLikesComp = "null";
    }
    $likes = $tweetsUser->sum('favorite_count');
    $avgLikes = $likes/8;
    $avgLikes = round($avgLikes);

    return response()->json(
            [
              'status' => 200,
              'message' => 'success',
              'response' => [
                'avgLikes' => $avgLikes,
                'avgLikesComp' => $avgLikesComp
              ]
            ]
    );
  }

  public function showReplies()
  {
    $tweetsUser = TwitterTweet::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->where('created_at','>=', Carbon::today()->subWeek())->get();
    $competitors = Competitor::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->get();

    $repliesComp = 0;
    if (count($competitors) > 1) {
      foreach($competitors as $competitor)
      {
        $tweetsComp = TwitterTweet::where('twitter_id','=',$competitor->competitor_id)->where('created_at','>=', Carbon::today()->subWeek());

        $replies = $tweetsComp->sum('replies_count');
        $repliesComp = $repliesComp + $replies;
      }
      $avgRepliesComp = $repliesComp/8/count($competitors);
      $avgRepliesComp = round($avgRepliesComp);
    } else {
      $avgRepliesComp = "null";
    }
    $replies = $tweetsUser->sum('replies_count');
    $avgReplies = $replies/8;
    $avgReplies = round($avgReplies);

    return response()->json(
            [
              'status' => 200,
              'message' => 'success',
              'response' => [
                'avgReplies' => $avgReplies,
                'avgRepliesComp' => $avgRepliesComp
              ]
            ]
    );
  }

  public function showInsight()
  {
    //initiate variables
    $followersComp = 0;
    $postingComp = 0;
    $retweetComp = 0;
    $likeComp = 0;
    $repliesComp = 0;
    $positiveSentiment = 0;
    $negativeSentiment = 0;
    $neutralSentiment = 0;
    $avgFollowersComp = 0;
    $avgPostsComp = 0;
    $avgRetweetsComp = 0;
    $avgLikesComp = 0;
    $avgRepliesComp = 0;
    $insight = 0;
    $tweetRecommendation = '';
    $postingRecommendation = '';
    $mentionRecommendation = '';

    //get data
    $followersNowUser = TwitterAccountLog::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->orderBy('created_at', 'desc')->first();
    $followersWeekAgoUser = TwitterAccountLog::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->where('created_at','>=', Carbon::today()->subWeek())->first();
    $tweetsUser = TwitterTweet::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->where('created_at','>=', Carbon::today()->subWeek())->get();
    foreach($tweetsUser as $tweetUser) {
      $getData = TwitterReply::where('tweet_id','=',$tweetUser->tweet_id)->where('sentiment','=','positif');
      $positiveSentiment = $positiveSentiment + $getData->count();
      $getData = TwitterReply::where('tweet_id','=',$tweetUser->tweet_id)->where('sentiment','=','negatif');
      $negativeSentiment = $negativeSentiment + $getData->count();
    }
    $posting = $tweetsUser->count();
    $retweet = $tweetsUser->sum('retweet_count');
    $like = $tweetsUser->sum('favorite_count');
    $replies = $tweetsUser->sum('replies_count');

    $recommendTodaysTweet = TwitterTweet::where('twitter_id','=', Auth::user()->twitterAccount->twitter_id)->whereDate('tweet_created','=',Carbon::today())->first();
    $recommendMention = TwitterTweet::where('twitter_id','=', Auth::user()->twitterAccount->twitter_id)->whereDate('tweet_created','=',Carbon::today())->whereNotNull('reply_screen_name')->first();
    $bestHour = TwitterTweet::getBestHour();
    $competitors = Competitor::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->get();
    foreach($competitors as $competitor)
    {
      $followersNowComp = TwitterAccountLog::where('twitter_id','=',$competitor->competitor_id)->orderBy('created_at', 'desc')->first();
      $followersWeekAgoComp = TwitterAccountLog::where('twitter_id','=',$competitor->competitor_id)->where('created_at','>=', Carbon::today()->subWeek())->first();
      $tweetsComp = TwitterTweet::where('twitter_id','=',$competitor->competitor_id)->where('created_at','>=', Carbon::today()->subWeek());

      $followersComp = $followersComp + ($followersNowComp->followers_count - $followersWeekAgoComp->followers_count);
      $postingC = $tweetsComp->count();
      $postingComp = $postingComp + $postingC;
      $retweetC = $tweetsComp->sum('retweet_count');
      $retweetComp = $retweetComp + $retweetC;
      $likeC = $tweetsComp->sum('favorite_count');
      $likeComp = $likeComp + $likeC;
      $repliesC = $tweetsComp->sum('replies_count');
      $repliesComp = $repliesComp + $repliesC;
    }

    //count average

    $avgFollowers = ($followersNowUser->followers_count - $followersWeekAgoUser->followers_count)/8;
    $avgFollowers = round($avgFollowers);
    $avgPosts = $posting/8;
    $avgRetweets = $retweet/8;
    $avgLikes = $like/8;
    $avgReplies = $replies/8;

    if (count($competitors) > 0)
    {
      $avgFollowersComp = $followersComp/8/count($competitors);
      $avgFollowersComp = round($avgFollowersComp);
      $avgPostsComp = $postingComp/8/count($competitors);
      $avgRetweetsComp = $retweetComp/8/count($competitors);
      $avgLikesComp = $likeComp/8/count($competitors);
      $avgRepliesComp = $repliesComp/8/count($competitors);
    }
    //initiate compare array
    $usersCompare = array(round($avgFollowers),round($avgPosts), round($avgRetweets), round($avgLikes), round($avgReplies), round($positiveSentiment));
    $compCompare = array(round($avgFollowersComp), round($avgPostsComp), round($avgRetweetsComp), round($avgLikesComp), round($avgRepliesComp), round($negativeSentiment));

    //count insight
    for ($i=0 ; $i < count($usersCompare) ; $i++ ) {
      if ($usersCompare[$i]>$compCompare[$i]) {
        $insight++;
      }
    }

    if ($insight > 3) {
      $insightIcon = 'far fa-smile';
      $insightText = "Aktivitas anda seminggu ini baik!";
    } else {
      $insightIcon = 'far fa-frown';
      $insightText = "Aktivitas anda seminggu ini perlu ditingkatkan!";
    }
    return response()->json(
            [
              'status' => 200,
              'message' => 'success',
              'response' => [
                'insightIcon' => $insightIcon,
                'insightText' => $insightText
              ]
            ]
    );
  }

  public function showRecommendation()
  {
    $tweetRecommendation = '';
    $postingRecommendation = '';
    $mentionRecommendation = '';
    $avgPostsComp = 0;

    $recommendTodaysTweet = TwitterTweet::where('twitter_id','=', Auth::user()->twitterAccount->twitter_id)->whereDate('tweet_created', Carbon::today())->whereNull('reply_screen_name')->first();
    $recommendMention = TwitterTweet::where('twitter_id','=', Auth::user()->twitterAccount->twitter_id)->whereDate('tweet_created', Carbon::today())->whereNotNull('reply_screen_name')->first();
    $bestHour = TwitterTweet::getBestHour();
    $tweetsUser = TwitterTweet::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->where('created_at','>=', Carbon::today()->subWeek())->get();
    $posting = $tweetsUser->count();
    $competitors = Competitor::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->get();
    $postingComp = TwitterTweet::getCompetitorPosts($competitors);

    $avgPosts = $posting/8;

    if(count($competitors)){
      $avgPostsComp = $postingComp/8/count($competitors);
    }

    if (empty($recommendTodaysTweet)) {
      $tweetRecommendation = '<span><i class="fas fa-lightbulb"></i> Posting tweet hari ini</span><br>';
    }
    if ($avgPosts < $avgPostsComp) {
      $postRecommendation = round($avgPostsComp) - round($avgPosts) + 1;
      $postingRecommendation = '<span><i class="fas fa-lightbulb"></i> Sebaiknya hari ini anda post ' . $postRecommendation . ' tweet lagi</span><br>';
    }
    if (empty($recommendMention)) {
      $mentionRecommendation = '<span><i class="fas fa-lightbulb"></i> Menanggapi mention masuk kepada anda</span><br>';
    }

    return response()->json(
            [
              'status' => 200,
              'message' => 'success',
              'response' => [
                'bestHour' => $bestHour,
                'tweetRecommendation' => $tweetRecommendation,
                'postingRecommendation' => $postingRecommendation,
                'mentionRecommendation' => $mentionRecommendation
              ]
            ]
    );
  }

  public function showSentiment()
  {
    $tweetsUser = TwitterTweet::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->where('created_at','>=', Carbon::today()->subWeek())->get();
    $sample = TwitterReply::getSample();
    $sentiment = TwitterReply::getSentimentData($tweetsUser);

    $totalSentiment = array_sum($sentiment);
    if ($totalSentiment > 0)
    {
      $sentiment[0] = $sentiment[0] / $totalSentiment * 100;
      $sentiment[1] = $sentiment[1] / $totalSentiment * 100;
      $sentiment[2] = $sentiment[2] / $totalSentiment * 100;
    }

    return response()->json(
            [
              'status' => 200,
              'message' => 'success',
              'response' => [
                'positiveSentiment' => $sentiment[0],
                'neutralSentiment' => $sentiment[1],
                'negativeSentiment' => $sentiment[2],
                'totalSentiment' => $totalSentiment,
                'samplingPositiveContent' => mb_convert_encoding($sample[0], 'UTF-8', 'UTF-8'),
                'samplingPositiveUser' => mb_convert_encoding($sample[1], 'UTF-8', 'UTF-8'),
                'samplingNegativeContent' => mb_convert_encoding($sample[2], 'UTF-8', 'UTF-8'),
                'samplingNegativeUser' => mb_convert_encoding($sample[3], 'UTF-8', 'UTF-8'),
              ]
            ]
    );
  }

  public function showTopTweets()
  {
    $twitterAccountLog = TwitterAccountLog::where('twitter_id','=',Auth::user()->twitterAccount->twitter_id)->orderBy('created_at','desc')->first();
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
    $twitterAccountLog['description'] = mb_convert_encoding($twitterAccountLog['description'], 'UTF-8', 'UTF-8');
    return response()->json(
            [
              'status' => 200,
              'message' => 'success',
              'response' => [
                'twitterAccountLog' => $twitterAccountLog,
                'topTweets' => $topTweets->toArray(),
                'positiveTopTweet' => $positiveTopTweet,
                'negativeTopTweet' => $negativeTopTweet
              ]
            ]
    );
  }

}
