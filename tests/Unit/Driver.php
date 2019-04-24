<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\User;
use App\TwitterAccount;
use App\TwitterTweet;
use App\TwitterReply;
use App\Competitor;
use Carbon\Carbon;
use App\Http\Controllers\DashboardController;
class Driver extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
     //

     // select * from twitter_accounts where twitter_id = '987'
     // select * from twitter_tweets where twitter_id = '987'
     // select * from twitter_replies where tweet_id = '876'
     //
     // select * from twitter_accounts where twitter_id = '987'
     // delete twitter_tweets where twitter_id = '987'
     // delete twitter_replies where tweet_id = '876'


    public function test_lihat_rekomendasi_jalur_1()
    {
      $user = factory(User::class)->make([
            'id' => 125,
      ]);
      // user
      $twitterAccount = factory(TwitterAccount::class)->create([
        'account_id' => 125,
        'twitter_id' => 1223,
      ]);
      $twitterTweet = factory(TwitterTweet::class)->create([
        'twitter_id' => 1223,
        'tweet_id' => 323,
        'tweet_created' => '2019-04-22 13:12:28.000',
      ]);
      $twitterMention = factory(TwitterTweet::class)->create([
        'twitter_id' => 1223,
        'tweet_id' => 324,
        'tweet_created' => '2019-04-22 13:12:28.000',
        'reply_status_id' => 111,
        'reply_user_id' => 222,
        'reply_screen_name' => 'testing'
      ]);
      $bestTweet = factory(TwitterTweet::class)->create([
        'twitter_id' => 1223,
        'tweet_id' => 325,
        'tweet_created' => '2019-04-22 13:12:28.000',
        'recommendation' => 1,
        'created_at' => Carbon::yesterday()
      ]);

      $this->actingAs($user);
      $hasil = $this->get('/dashboard/showRecommendation')->json();

      $this->assertEquals([
        'status' => 200,
        'message' => 'success',
        'response' => [
          'bestHour' => [['hour' => 13, 'count'=>3]],
          'tweetRecommendation' => '',
          'postingRecommendation' => '',
          'mentionRecommendation' => ''
        ]
  		], $hasil);
    }

    public function test_lihat_rekomendasi_jalur_2()
    {
      $user = factory(User::class)->make([
            'id' => 126,
      ]);

      // user
      $twitterAccount = factory(TwitterAccount::class)->create([
        'account_id' => 126,
        'twitter_id' => 1225,
      ]);
      // competitor
      $twitterCompetitor = factory(TwitterAccount::class)->create([
        'twitter_id' => 1226,
      ]);
      $competitor = factory(Competitor::class)->create([
        'twitter_id' => 1225,
        'competitor_id' => 1226,
      ]);
      $twitterTweet = factory(TwitterTweet::class)->create([
        'twitter_id' => 1225,
        'tweet_id' => 335,
        'tweet_created' => '2019-04-22 13:12:28.000',
      ]);
      $twitterMention = factory(TwitterTweet::class)->create([
        'twitter_id' => 1225,
        'tweet_id' => 336,
        'tweet_created' => '2019-04-22 13:12:28.000',
        'reply_status_id' => 111,
        'reply_user_id' => 222,
        'reply_screen_name' => 'testing'
      ]);
      $bestTweet = factory(TwitterTweet::class)->create([
        'twitter_id' => 1225,
        'tweet_id' => 337,
        'tweet_created' => '2019-04-22 13:12:28.000',
        'recommendation' => 1,
        'created_at' => Carbon::yesterday()
      ]);

      $this->actingAs($user);
      $hasil = $this->get('/dashboard/showRecommendation')->json();

      $this->assertEquals([
        'status' => 200,
        'message' => 'success',
        'response' => [
          'bestHour' => [['hour' => 13, 'count'=>3]],
          'tweetRecommendation' => '',
          'postingRecommendation' => '',
          'mentionRecommendation' => ''
        ]
  		], $hasil);
    }

    public function test_lihat_rekomendasi_jalur_3()
    {
      $user = factory(User::class)->make([
            'id' => 127,
        ]);

        // user
        $twitterAccount = factory(TwitterAccount::class)->create([
          'account_id' => 127,
          'twitter_id' => 1227,
        ]);
        // competitor
        $twitterCompetitor = factory(TwitterAccount::class)->create([
          'twitter_id' => 1228,
        ]);
        $competitor = factory(Competitor::class)->create([
          'twitter_id' => 1227,
          'competitor_id' => 1228,
        ]);
        $twitterMention = factory(TwitterTweet::class)->create([
          'twitter_id' => 1227,
          'tweet_id' => 338,
          'tweet_created' => '2019-04-22 13:12:28.000',
          'reply_status_id' => 111,
          'reply_user_id' => 222,
          'reply_screen_name' => 'testing'
        ]);
        $bestTweet = factory(TwitterTweet::class)->create([
          'twitter_id' => 1227,
          'tweet_id' => 339,
          'tweet_created' => '2019-04-21 13:12:28.000',
          'recommendation' => 1,
          'created_at' => Carbon::yesterday()
        ]);

        $this->actingAs($user);
        $hasil = $this->get('/dashboard/showRecommendation')->json();

        $this->assertEquals([
          'status' => 200,
          'message' => 'success',
          'response' => [
            'bestHour' => [['hour' => 13, 'count'=>2]],
            'tweetRecommendation' => '<span><i class="fas fa-lightbulb"></i> Posting tweet hari ini</span><br>',
            'postingRecommendation' => '',
            'mentionRecommendation' => ''
          ]
        ], $hasil);
    }

    public function test_lihat_rekomendasi_jalur_4()
    {
      $user = factory(User::class)->make([
            'id' => 128,
        ]);
        $twitterAccount = factory(TwitterAccount::class)->create([
          'account_id' => 128,
          'twitter_id' => 1229,
        ]);
        // competitor
        $twitterCompetitor = factory(TwitterAccount::class)->create([
          'twitter_id' => 1230,
        ]);
        $competitor = factory(Competitor::class)->create([
          'twitter_id' => 1229,
          'competitor_id' => 1230,
        ]);
        $competitorTweet = factory(TwitterTweet::class)->create([
          'twitter_id' => 1230,
          'tweet_id' => 340,
          'tweet_created' => '2019-04-22 13:12:28.000',
        ]);
        $competitorTweet2 = factory(TwitterTweet::class)->create([
          'twitter_id' => 1230,
          'tweet_id' => 341,
          'tweet_created' => '2019-04-22 13:13:28.000',
        ]);
        $competitorTweet3 = factory(TwitterTweet::class)->create([
          'twitter_id' => 1230,
          'tweet_id' => 342,
          'tweet_created' => '2019-04-22 13:14:28.000',
        ]);
        $twitterMention = factory(TwitterTweet::class)->create([
          'twitter_id' => 1229,
          'tweet_id' => 343,
          'tweet_created' => '2019-04-22 13:12:28.000',
          'reply_status_id' => 111,
          'reply_user_id' => 222,
          'reply_screen_name' => 'testing'
        ]);
        $bestTweet = factory(TwitterTweet::class)->create([
          'twitter_id' => 1229,
          'tweet_id' => 344,
          'tweet_created' => '2019-04-21 13:12:28.000',
          'recommendation' => 1,
          'created_at' => Carbon::yesterday()
        ]);
        $this->actingAs($user);
        $hasil = $this->get('/dashboard/showRecommendation')->json();

        $this->assertEquals([
          'status' => 200,
          'message' => 'success',
          'response' => [
            'bestHour' => [['hour' => 13, 'count'=>2]],
            'tweetRecommendation' => '<span><i class="fas fa-lightbulb"></i> Posting tweet hari ini</span><br>',
            'postingRecommendation' => '<span><i class="fas fa-lightbulb"></i> Sebaiknya hari ini anda post 1 tweet lagi</span><br>',
            'mentionRecommendation' => ''
          ]
        ], $hasil);
    }

    public function test_lihat_rekomendasi_jalur_5()
    {
      $user = factory(User::class)->make([
            'id' => 129,
        ]);
        $twitterAccount = factory(TwitterAccount::class)->create([
          'account_id' => 129,
          'twitter_id' => 1231,
        ]);
        // competitor
        $twitterCompetitor = factory(TwitterAccount::class)->create([
          'twitter_id' => 1232,
        ]);
        $competitor = factory(Competitor::class)->create([
          'twitter_id' => 1231,
          'competitor_id' => 1232,
        ]);
        $competitorTweet = factory(TwitterTweet::class)->create([
          'twitter_id' => 1232,
          'tweet_id' => 345,
          'tweet_created' => '2019-04-22 13:12:28.000',
        ]);
        $competitorTweet2 = factory(TwitterTweet::class)->create([
          'twitter_id' => 1232,
          'tweet_id' => 346,
          'tweet_created' => '2019-04-22 13:13:28.000',
        ]);
        $bestTweet = factory(TwitterTweet::class)->create([
          'twitter_id' => 1231,
          'tweet_id' => 347,
          'tweet_created' => '2019-04-21 13:12:28.000',
          'recommendation' => 1,
          'created_at' => Carbon::yesterday()
        ]);
        $this->actingAs($user);
        $hasil = $this->get('/dashboard/showRecommendation')->json();

        $this->assertEquals([
          'status' => 200,
          'message' => 'success',
          'response' => [
            'bestHour' => [['hour' => 13, 'count'=>1]],
            'tweetRecommendation' => '<span><i class="fas fa-lightbulb"></i> Posting tweet hari ini</span><br>',
            'postingRecommendation' => '<span><i class="fas fa-lightbulb"></i> Sebaiknya hari ini anda post 1 tweet lagi</span><br>',
            'mentionRecommendation' => '<span><i class="fas fa-lightbulb"></i> Menanggapi mention masuk kepada anda</span><br>'
          ]
        ], $hasil);
    }

    public function test_lihat_hasil_sentimen_analisis_jalur_1()
    {
      $user = factory(User::class)->make([
            'id' => 122,
        ]);
      $twitterAccount = factory(TwitterAccount::class)->make([
        'account_id' => 122,
        'twitter_id' => 1222,
      ]);
      $twitterTweet = factory(TwitterTweet::class)->make([
        'twitter_id' => 1222,
        'tweet_id' => 322
      ]);

      $user->setRelation('twitterAccount', $twitterAccount);

      $this->actingAs($user);
      $hasil = $this->get('/dashboard/showSentiment')->json();
      $this->assertEquals([
        'status' => 200,
        'message' => 'success',
        'response' => [
          'positiveSentiment' => 0,
          'neutralSentiment' => 0,
          'negativeSentiment' => 0,
          'totalSentiment' => 0,
          'samplingPositiveContent' => [],
          'samplingPositiveUser' => [],
          'samplingNegativeContent' => [],
          'samplingNegativeUser' => [],
        ]
  		], $hasil);
    }

    public function test_lihat_hasil_sentimen_analisis_jalur_2()
    {
      $user = factory(User::class)->make([
            'id' => 234,
        ]);
      $twitterAccount = factory(TwitterAccount::class)->create([
        'account_id' => 234,
        'twitter_id' => 987,
      ]);
      $twitterTweet = factory(TwitterTweet::class)->create([
        'twitter_id' => 987,
        'tweet_id' => 876
      ]);
      $twitterReply = factory(TwitterReply::class)->create([
        'tweet_id' => 876,
        'replies_id' => 1,
        'sentiment' => 'positif'
      ]);
      $twitterReply2 = factory(TwitterReply::class)->create([
        'tweet_id' => 876,
        'replies_id' => 2,
        'sentiment' => 'netral'
      ]);
      $twitterReply3 = factory(TwitterReply::class)->create([
        'tweet_id' => 876,
        'replies_id' => 3,
        'sentiment' => 'negatif'
      ]);

      $this->actingAs($user);
      $hasil = $this->get('/dashboard/showSentiment')->json();

      $this->assertEquals([
        'status' => 200,
        'message' => 'success',
        'response' => [
          'positiveSentiment' => 33.33333333333333,
          'neutralSentiment' => 33.33333333333333,
          'negativeSentiment' => 33.33333333333333,
          'totalSentiment' => 3,
          'samplingPositiveContent' => ['White Rabbit, trotting slowly back again, and Alice was not even room for her. \'I wish you could keep it to make the arches. The chief difficulty Alice found at first was in the sea. But they HAVE.'],
          'samplingPositiveUser' => ['linwood81'],
          'samplingNegativeContent' => ['Rabbit asked. \'No, I give it up,\' Alice replied: \'what\'s the answer?\' \'I haven\'t the least idea what to do this, so that altogether, for the hot day made her next remark. \'Then the Dormouse fell.'],
          'samplingNegativeUser' => ['joannie.lind'],
        ]
  		], $hasil);
    }

    public function test_lihat_tren_topik_indonesia()
    {
      $this->withoutMiddleware();
      $this->get('trend')->assertSee('Daftar Tren Topik Indonesia');
    }
}
