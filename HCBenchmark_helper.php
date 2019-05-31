<?php defined('BASEPATH') OR exit('No direct script access allowed.');

if (!function_exists('bycryptCostBenchmark')) {
  $upperTimeLimit = 1000;
  $password = 'this_is_just_a_long_string_to_test_on_U8WNZqmz8ZVBNiNTQR8r';
  if (php_sapi_name() !== 'cli' ) echo "<pre>";
  echo "\nPassword BCRYPT Hash Cost Calculator\n\n";
  echo "We're going to run until the time to generate the hash takes longer than {$upperTimeLimit}ms\n";
  $cost = 3;
  $first_cost_above_100 = null;
  $first_cost_above_500 = null;
  do {
      $cost++;

      echo "\nTesting cost value of $cost: ";

      $start = microtime(true);
      password_hash($password, PASSWORD_BCRYPT, array('cost' => $cost));
      $time = round((microtime(true) - $start) * 1000);

      echo "... took {$time}ms";

      if ($first_cost_above_100 === null && $time > 100) {
          $first_cost_above_100 = $cost;
      } else if ($first_cost_above_500 === null && $time > 500) {
          $first_cost_above_500 = $cost;
      }

  } while ($time < $upperTimeLimit);
  echo "\n\n\nYou should use a cost between $first_cost_above_100 and $first_cost_above_500";
}
