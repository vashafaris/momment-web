<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterTweet extends Model
{
  protected $table = 'twitter_tweets';

  public $incrementing = false;

  public function twitterAccount()
  {
    return $this->belongsTo('App\TwitterAccount','twitter_id');
  }

  public function twitterReply()
  {
    return $this->hasMany('App\TwitterReply','tweet_id');
  }

  protected $casts = [
    'created_at' => 'datetime:Y-m-d',
];
}
