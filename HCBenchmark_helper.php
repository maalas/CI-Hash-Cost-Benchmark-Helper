<?php defined('BASEPATH') OR exit('No direct script access allowed.');

if (!function_exists('bycryptCostBenchmark')) {
  /*
     * Password Bycrypt Hash Benchmark
     * 
     * This Snip Script I got from Indigo744 Github Gist:
     * https://gist.github.com/Indigo744/24062e07477e937a279bc97b378c3402
     * 
     * Then I convert it to be a CodeIgniter Helper.
     */
    function bycryptCostBenchmark($upperTimeLimit = 1000, $showDebug = FALSE){
        $password = 'this_is_just_a_long_string_to_test_on_U8WNZqmz8ZVBNiNTQR8r';
        if (php_sapi_name() !== 'cli' && $showDebug) echo "<pre>";
        
        if($showDebug){
            echo "\nPassword BCRYPT Hash Cost BENCHMARK\n\n";
            echo "We're going to run until the time to generate the hash takes longer than {$upperTimeLimit}ms\n";
        }
        
        $cost = 3;
        $first_cost_above_100 = null;
        $first_cost_above_500 = null;
        
        do {
            $cost++;

            if ($showDebug) echo "\nTesting cost value of $cost: ";

            $start = microtime(true);
            password_hash($password, PASSWORD_BCRYPT, array('cost' => $cost));
            $time = round((microtime(true) - $start) * 1000);

            if ($showDebug) echo "... took {$time}ms";

            if ($first_cost_above_100 === null && $time > 100) {
                $first_cost_above_100 = $cost;
            } else if ($first_cost_above_500 === null && $time > 500) {
                $first_cost_above_500 = $cost;
            }

        } while ($time < $upperTimeLimit);

        if ($showDebug) echo "\n\n\nYou should use a cost between $first_cost_above_100 and $first_cost_above_500";
        
        $result = new stdClass();
        $result->lowCost = $first_cost_above_100;
        $result->HightCost = $first_cost_above_500;

        return $result;
    }
}
