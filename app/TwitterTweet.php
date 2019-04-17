<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TwitterTweet extends Model
{
  protected $table = 'twitter_tweets';

  public $incrementing = false;

  protected $casts = [
    'created_at' => 'datetime:Y-m-d',
  ];

  public static function getBestHour()
  {
    return DB::select('select datepart(hour,tweet_created) as \'hour\', count(datepart(hour,tweet_created)) as \'count\' from ( select top 10 * from twitter_tweets  WHERE NOT (cast(tweet_created as date) <= DATEADD(day, -7, convert(date, GETDATE())) OR cast(tweet_created as date) >= DATEADD(day, 0, convert(date, GETDATE()))) and twitter_id = \'' . Auth::user()->twitterAccount->twitter_id . '\'  order by recommendation desc) a  group by datepart(hour,tweet_created) order by count desc');
  }

  public static function getCompetitorPosts($competitors)
  {
    $postingComp = 0;
    foreach($competitors as $competitor)
    {
      $tweetsComp = TwitterTweet::where('twitter_id','=',$competitor->competitor_id)->where('created_at','>=', Carbon::today()->subWeek());
      $posting = $tweetsComp->count();
      $postingComp = $postingComp + $posting;
    }
    return $postingComp;
  }

  public function twitterAccount()
  {
    return $this->belongsTo('App\TwitterAccount','twitter_id');
  }

  public function twitterReply()
  {
    return $this->hasMany('App\TwitterReply','tweet_id');
  }
}
