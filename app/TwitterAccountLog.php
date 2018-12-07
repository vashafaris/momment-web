<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterAccountLog extends Model
{
  protected $table = 'twitter_accounts_log';

  protected $keyType = 'string';

  public $incrementing = false;
}
