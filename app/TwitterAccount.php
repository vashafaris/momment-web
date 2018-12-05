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

}
