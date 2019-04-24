<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $incrementing = false;

    protected $fillable = [
        'id', 'name', 'email', 'password',
    ];

    public static $rules = [
      'name' => 'required',
      'email' => 'required|unique:users,email',
      'password' => 'required|min:6'
    ];

    public static $password_rules = [
        'password' => 'required|min:6',
    ];

    public static $messages = [
        'required' => ':Isi field ini terlebih dahulu',
        'unique' => ':E-mail tidak tersedia',
        'min' => ':Minimal :min karakter'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function twitterAccount ()
    {
      return $this->hasOne('App\TwitterAccount','account_id');
    }
}
