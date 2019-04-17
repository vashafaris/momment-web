<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterAccount extends Model
{
    protected $table = 'twitter_accounts';

    public $incrementing = false;

    protected $keyType = 'string';

    public function user()
    {
      return $this->belongsTo('App\User','id');
    }

    public function twitterTweet()
    {
      return $this->hasMany('App\TwitterTweet','twitter_id');
    }

    public function twitterAccountLog()
    {
      return $this->hasMany('App\TwitterTweet','twitter_id');
    }

    public function competitor()
    {
      return $this->hasMany('App\Competitor','twitter_id');
    }
}
