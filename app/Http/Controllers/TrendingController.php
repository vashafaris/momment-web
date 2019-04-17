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
      $trendDate = TwitterTrend::max('created_at');
      $trendDate = explode(" ",$trendDate)[0];
      $twitterTrend = TwitterTrend::whereDate('created_at','=',$trendDate)->orderBy('id_trend','asc')->get();
      return view('contents.trend', [
        'twitterTrend' => $twitterTrend
      ]);
  }

  public function detail($id_trend)
  {
    $trendName = TwitterTrend::where('id_trend','=',$id_trend)->get()->toArray();
    $trendDetails = TwitterTrendDetail::where('id_trend','=',$id_trend)->orderBy('recommendation','desc')->get()->toArray();
    return response()->json(
            [
                'status' => 200,
                'message' => 'success',
                'response' => [
                    'trend_name' => mb_convert_encoding($trendName, 'UTF-8', 'UTF-8'),
                    'trend_details' => mb_convert_encoding($trendDetails, 'UTF-8', 'UTF-8')
                ]
            ]
    );
  }
}
