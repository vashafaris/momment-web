<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Competitor::class, function (Faker $faker) {
    return [
        'twitter_id' => $faker->unique()->numberBetween($min = 10000000, $max = 99999999),
        'competitor_id' => $faker->unique()->numberBetween($min = 10000000, $max = 99999999),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ];
});

$factory->define(App\TwitterAccount::class, function (Faker $faker) {
  return [
    'twitter_id' => $faker->unique()->numberBetween($min = 10000000, $max = 99999999),
    'account_id' => $faker->unique()->numberBetween($min = 123, $max = 300),
    'is_account' => 0,
    'is_competitor' => 0,
    'created_at' => Carbon::now(),
    'updated_at' => Carbon::now(),
  ];
});

$factory->define(App\TwitterTweet::class, function (Faker $faker) {
  return [
    'tweet_id' => $faker->unique()->numberBetween($min = 10000, $max = 99999),
    'twitter_id' => $faker->unique()->numberBetween($min = 10000000, $max = 99999999),
    'tweet_created' => '2019-04-17 20:41:46.0',
    'tweet_content' => $faker->realText($maxNbChars = 200),
    'tweet_media' => null,
    'location' => null,
    'retweet_count' => $faker->numberBetween($min = 0, $max = 1000),
    'favorite_count' => $faker->numberBetween($min = 0, $max = 1000),
    'replies_count' => $faker->numberBetween($min = 0, $max = 1000),
    'reply_status_id' => null,
    'reply_user_id' => null,
    'reply_screen_name' => null,
    'recommendation' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0.001, $max = 0.3),
    'created_at' => Carbon::now(),
  ];
});

$factory->define(App\TwitterReply::class, function (Faker $faker) {
  $random = rand(0,2);
  $sentiment = 'positif';
  if($random == 1) {
    $sentiment = 'netral';
  } else if ($random == 2) {
    $sentiment = 'negatif';
  }
  return [
    'replies_id' => $faker->unique()->numberBetween($min = 1000000, $max = 9999999),
    'tweet_id' => $faker->unique()->numberBetween($min = 10000, $max = 99999),
    'replies_content' => $faker->realText($maxNbChars = 200),
    'replies_media' => null,
    'name' => $faker->firstNameMale,
    'screen_name' => $faker->userName,
    'reply_account_photo' => null,
    'sentiment' => $sentiment,
    'sentiment_weight' => $faker->unique()->numberBetween($min = -3, $max = 3),
    'created_at' => Carbon::now(),
  ];
});
