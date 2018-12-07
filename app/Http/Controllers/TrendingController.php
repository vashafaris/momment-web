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
      // $date = TwitterTrend::get()->orderBy('created_at', 'desc')->first();
      // $twitterTrend = TwitterTrend::get()->where('created_at', $twitterDate[0]->created_at);

      // $twitterDate = DB::select('select top 1 created_at from twitter_trends order by created_at desc');
      $carousel = [];
      $countTweetPic = 0;
      $twitterDate = DB::select ('select max(cast(created_at as date)) as created_at from twitter_trends');
      $twitterTrend = DB::select('select * from twitter_trends where cast(created_at as date) = \'' . $twitterDate[0]->created_at . '\' order by id_to_details asc');

      $twitterDetails = DB::select('select * from twitter_trend_details where cast(created_at as date) = \'' . $twitterDate[0]->created_at . '\'  order by id_to_trending asc');
      // for ($i=1; $i <= 10; $i++) {
      //   $checkCarousel = DB::select('select * from twitter_trend_details where cast(created_at as date) = \'' . $twitterDate[0]->created_at . '\' and id_to_trending = ' . $i);
      //   for ($j=0; $j < count($checkCarousel); $j++) {
      //     if (!empty($checkCarousel[$j])) {
      //       $carousel[$j] =
      //     }
      //   }
      //   if ($checkCarousel->isEmpty()) {
      //     $carousel[$i] = 'none';
      //   } else {
      //     $carousel[$i] = '';
      //   }
      // }
      // dd($carousel);

      return view('contents.trends', [
        'twitterTrend' => $twitterTrend,
        'twitterDetails' => $twitterDetails
      ]);
  }
}
