<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterAccountLog extends Model
{
  protected $table = 'twitter_accounts_log';

  public $incrementing = false;

  protected $keyType = 'string';

  public function user()
  {
    return $this->belongsTo('App\User','id');
  }
}
