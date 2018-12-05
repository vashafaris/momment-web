<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $incrementing = false;

    protected $fillable = [
        'name', 'email', 'password',
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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function twitterAccount ()
    {
      return $this->hasOne('App\TwitterAccount','account_id');
    }
}
