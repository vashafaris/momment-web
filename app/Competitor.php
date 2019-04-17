<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competitor extends Model
{
  protected $table = 'competitor';

  public $incrementing = false;

  public function twitterAccount()
  {
    return $this->belongsTo('App\TwitterAccount','twitter_id');
  }
}
