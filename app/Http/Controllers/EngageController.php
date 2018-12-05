<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\TwitterAccount;
use App\User;
use Kozz\Laravel\Facades\Guzzle;
use GuzzleHttp\Client;

class EngageController extends Controller
{
  protected $request;

  public function __construct(Request $request)
  {
      $this->request = $request;
  }

  public function index()
  {
      if (TwitterAccount::where('account_id', '=', Auth::user()->id)->exists()) {

        $accountData = TwitterAccount::get();

        $banner_url = 'style="background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4)), url(\'{{ asset(\'images/default-background.jpg \') }}\');height: 200px;width: 100%;background-size: cover;background-position: center;"';
        if ($accountData[0]->banner_url !== null)
        {
          $banner_url = 'style="background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4)), url(\'' . $accountData[0]->banner_url . '\');height: 200px;width: 100%;background-size: cover;background-position: center;"';
        }

        $photo_url = '<img src="{{ asset(\'images/default-photo.png \') }}" style="height: 64px;width: 64px;object-fit: cover;border: 2px solid white;position: absolute;border-radius: 50%;top: 70px;left: 24px;">';
        if ($accountData[0]->photo_url !== null)
        {
          $photo_url = '<img src="' . $accountData[0]->photo_url . '" style="height: 64px;width: 64px;object-fit: cover;border: 2px solid white;position: absolute;border-radius: 50%;top: 70px;left: 24px;">';
        }

        $location = '';
        if ($accountData[0]->location !== null)
        {
          $location = '<div class="divider" style="margin: 10px 0;"></div><span style="font-size: 10pt;margin: 10px 0;"><i class="fas fa-map-marker-alt"></i> &nbsp; ' . $accountData[0]->location . '</span>';
        }

        $since = '';
        if ($accountData[0]->created !== null)
        {
          $since =   '<div class="divider" style="margin: 10px 0;"></div><span style="font-size: 10pt;margin: 10px 0;"><i class="far fa-calendar-alt"></i> &nbsp; Terdaftar Sejak formatDate(new Date(' . $accountData[0]->created. '))</span>';
        }

        return view('contents.account', [
            'banner_url' => compact('banner_url'),
            'photo_url' => compact('photo_url'),
            'location' => compact('location'),
            'since' => compact('since'),
            'accountData' => $accountData
        ]);
      }
      return view('contents.engage');
  }

  public function search($username)
  {
    $result = shell_exec("python " . public_path() . "\API\SearchTwitter.py " . $username);
    $result = json_decode($result);

   $isEngage = false;
    if (TwitterAccount::where('screen_name', '=', $username)->exists()) {
       $isEngage = true;
    }

    return response()->json(
            [
                'status' => 200,
                'message' => 'success',
                'response' => [
                    'profile' => $result,
                    'isEngage' => $isEngage
                ]
            ]
    );
  }

  public function addAccount($username)
  {
    $result = shell_exec("python " . public_path() . "\API\SearchTwitter.py " . $username);
    $response = json_decode($result);
    $temp = new TwitterAccount;
    $temp->twitter_id= $response[0]->user_id;
    $temp->account_id = Auth::user()->id;
    $temp->name = $response[0]->name;
    $temp->screen_name = $response[0]->screen_name;
    $temp->photo_url = $response[0]->photo_url;
    $temp->banner_url = $response[0]->banner_url;
    $temp->description = $response[0]->description;
    $temp->favorites_count = $response[0]->favorites_count;
    $temp->followers_count = $response[0]->followers_count;
    $temp->friends_count = $response[0]->friends_count;
    $temp->statuses_count = $response[0]->statuses_count;
    $temp->location = $response[0]->location;
    $temp->created = $response[0]->created;

    if($temp->save()){
      return response()->json([
        'status' =>200,
        'message' => 'berhasil menyambungkan akun'
      ]);
    } else {
      return response()->json([
        'status' => 405,
        'message' => 'gagal menyambungkan akun'
      ]);
    }
  }

  public function showAccount()
  {
    // // $client = new GuzzleHttp\Client();
    // $client = new Client();
    // $accountData = TwitterAccount::get()->where('account_id',Auth::user()->id);
    $accountData = DB::select('select * from twitter_accounts where account_id = ' . Auth::user()->id);

    // $tes = $accountData[2]->twitter_id;
    // dd($tes);

    // $response = $client->put(array(json_decode($accountData)));
    // $response = json_decode($accountData, TRUE);
    // dd($response);
    // $client->put($accountData);
    // dd(json_decode($accountData)->getBody());
    // return response($accountData);
    return response()->json(
            [
              'status' => 200,
              'message' => 'success',
              'response' => $accountData
            ]
    );
  }
}
