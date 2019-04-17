<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterTrendDetail extends Model
{
  protected $table = 'twitter_trend_detail';

  protected $keyType = 'string';

  public function twitterTrend()
  {
    return $this->belongsTo('App\TwitterTrend','id_trend');
  }
}
