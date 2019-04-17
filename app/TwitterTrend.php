<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TwitterTrend extends Model
{

  protected $table = 'twitter_trends';

  protected $keyType = 'string';

  public function twitterTrendDetail()
  {
    return $this->hasMany('App\TwitterTrendDetail','id_trend');
  }

}
