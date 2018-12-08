<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\TwitterTrend;
use App\TwitterTrendDetail;

class TrendingController extends Controller
{

  protected $request;

  public function __construct(Request $request)
  {
      $this->request = $request;
  }

  public function index()
  {
      $twitterDate = DB::select ('select max(cast(created_at as date)) as created_at from twitter_trends');
      $twitterTrend = DB::select('select * from twitter_trends where cast(created_at as date) = \'' . $twitterDate[0]->created_at . '\' order by id_to_details asc');
      $twitterDetails = DB::select('select * from twitter_trend_details where cast(created_at as date) = \'' . $twitterDate[0]->created_at . '\'  order by id_to_trending asc');
      return view('contents.trends', [
        'twitterTrend' => $twitterTrend,
        'twitterDetails' => $twitterDetails
      ]);
  }
}
