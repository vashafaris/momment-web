<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TwitterReply extends Model
{
  protected $table = 'twitter_replies';

  public $incrementing = false;

  public function twitterTweets()
  {
    return $this->belongsTo('App\TwitterTweet','tweet_id');
  }

  public static function getPositiveSample()
  {
    return DB::select('select a.screen_name, a.replies_content from twitter_replies a join twitter_tweets b on b.tweet_id = a.tweet_id where NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 0, convert(date, GETDATE()))) and b.twitter_id = \''. Auth::user()->twitterAccount->twitter_id .'\' and a.sentiment = \'positif\' order by a.sentiment_weight desc');
  }

  public static function getNegativeSample()
  {
    return DB::select('select a.screen_name, a.replies_content from twitter_replies a join twitter_tweets b on b.tweet_id = a.tweet_id where NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 0, convert(date, GETDATE()))) and b.twitter_id = \''. Auth::user()->twitterAccount->twitter_id .'\' and a.sentiment = \'negatif\' order by a.sentiment_weight');
  }

  public static function getSentimentData($tweetsUser)
  {
    $positiveSentiment = 0;
    $negativeSentiment = 0;
    $neutralSentiment = 0;
    foreach($tweetsUser as $tweetUser) {
      $getData = TwitterReply::where('tweet_id','=',$tweetUser->tweet_id)->where('sentiment','=','positif');
      $positiveSentiment = $positiveSentiment + $getData->count();
      $getData = TwitterReply::where('tweet_id','=',$tweetUser->tweet_id)->where('sentiment','=','netral');
      $neutralSentiment = $neutralSentiment + $getData->count();
      $getData = TwitterReply::where('tweet_id','=',$tweetUser->tweet_id)->where('sentiment','=','negatif');
      $negativeSentiment = $negativeSentiment + $getData->count();
    }
    $sentiment = [$positiveSentiment, $neutralSentiment, $negativeSentiment];
    return $sentiment;
  }

  public static function getSample()
  {
    $samplingPositiveContent = [];
    $samplingPositiveUser = [];
    $samplingNegativeContent = [];
    $samplingNegativeUser = [];

    $positiveSample = DB::select('select a.screen_name, a.replies_content from twitter_replies a join twitter_tweets b on b.tweet_id = a.tweet_id where NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 0, convert(date, GETDATE()))) and b.twitter_id = \''. Auth::user()->twitterAccount->twitter_id .'\' and a.sentiment = \'positif\' order by a.sentiment_weight desc');
    $negativeSample = DB::select('select a.screen_name, a.replies_content from twitter_replies a join twitter_tweets b on b.tweet_id = a.tweet_id where NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 0, convert(date, GETDATE()))) and b.twitter_id = \''. Auth::user()->twitterAccount->twitter_id .'\' and a.sentiment = \'negatif\' order by a.sentiment_weight');
    for ($i=0; $i < count($positiveSample); $i++) {
      array_push($samplingPositiveUser, $positiveSample[$i]->screen_name);
      array_push($samplingPositiveContent, $positiveSample[$i]->replies_content);
    }

    for ($i=0; $i < count($negativeSample); $i++) {
      array_push($samplingNegativeUser, $negativeSample[$i]->screen_name);
      array_push($samplingNegativeContent, $negativeSample[$i]->replies_content);
    }
    $sample = [$samplingPositiveContent, $samplingPositiveUser, $samplingNegativeContent, $samplingNegativeUser];
    return $sample;
  }
}
