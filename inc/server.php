<?php

    include_once 'algorithm.php';

    if (isset($_REQUEST)) {
        if (isset($_REQUEST['submit'])) {
            $message = $_REQUEST['message'];
        } else if (isset($_REQUEST['test'])) {
            $plain_text = '1010 0101';
            $key = '0010010111';
            $p10 = '3 5 2 7 4 10 1 9 8 6';
            $p8 = '6 3 7 4 8 5 1 0';
            $p4 = '2 4 3 1';
            $ip = '2 6 3 1 4 8 5 7';
            $ep = '4 1 2 3 2 3 4 1';
            
            # $k = '0 0 1 0 0 1 0 1 1 1';
            
            $plain_text = explode(' ', $plain_text);
            $p10 = explode(' ', $p10);
            $p8 = explode(' ', $p8);
            $p4 = explode(' ', $p4);
            $ip = explode(' ', $ip);
            $ep = explode(' ', $ep);

            $key = str_split($key);
            $key_length = sizeof($key);
            $k = array_slice($key, 0, $key_length);
            $k1 = array_slice($key, 0, $key_length / 2);
            $k2 = array_slice($key, $key_length / 2, $key_length);

            $des = new Des($plain_text, $key, $p10, $p8, $p4, $ip, $ep);
            # $des->get_keys($k1, $k2);
            $result = $des->premutation($p10, $k);
            print_r($result);
        }
    }
?>