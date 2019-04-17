<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterAccountLog extends Model
{
  protected $table = 'twitter_accounts_log';

  public $incrementing = false;

  protected $keyType = 'string';

  protected $casts = [
    'created_at' => 'datetime:Y-m-d',
  ];

  public function twitterAccount()
  {
    return $this->belongsTo('App\TwitterAccount','twitter_id');
  }

}
