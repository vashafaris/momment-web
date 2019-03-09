<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterReply extends Model
{
  protected $table = 'twitter_replies';

  public $incrementing = false;

  public function twitterTweets()
  {
    return $this->belongsTo('App\TwitterTweet','tweet_id');
  }
}
