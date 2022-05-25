<?php

    include_once 'algorithm.php';

    if (isset($_REQUEST)) {
        if (isset($_REQUEST['submit'])) {
            $message = $_REQUEST['message'];
            $p = random_int(2, 99);
            $q = random_int(2, 99);
            $xa = random_int(2, 9);
            $xb = random_int(2, 9);
            $dh = new DiffieHellman($p, $q, $xa, $xb);
            $keys = $dh->get_keys();
            echo '<h3>P & Q Definition - Randomly Generated</h3>';
            echo 'P: ' . $p . '<br/>';
            echo 'Q: ' . $q . '<br/>';
            echo '<h3>Private Keys Definition for Alice & Bob - Randomly Generated</h3>';
            echo 'Alice Private Key : ' . $xa . '<br/>';
            echo 'Bob Private Key : ' . $xb . '<br/>';
            echo '<h3>Public Keys Calculation for Alice & Bob</h3>';
            echo 'Alice Public Key : (P ^ Alice Private Key) Mod Q = (' . $p . ' ^ ' . $xa . ') Mod ' . $q . ' = ' . $keys[0] . '<br/>';
            echo 'Bob Public Key : (P ^ Bob Private Key) Mod Q = (' . $p . ' ^ ' . $xb . ') Mod ' . $q . ' = ' . $keys[1] . '<br/>';
            echo '<h3>Same Key for Alice & Bob - If both keys are the same, then it is CORRECT!</h3>';
            echo 'Alice Secret Key From Bob: (Bob Public Key ^ Alice Private Key) Mod Q = (' . $keys[0] . ' ^ ' . $xa . ') Mod ' . $q . ' = ' . $keys[2] . '<br/>';
            echo 'Bob Secret Key From Alice: (Alice Public Key ^ Bob Private Key) Mod Q = (' . $keys[1] . ' ^ ' . $xa . ') Mod ' . $q . ' = ' . $keys[3] . '<br/>';
        }
    }
?>