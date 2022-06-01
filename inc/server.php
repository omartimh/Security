<?php
    include_once 'des.php';
    if (isset($_REQUEST)) {
        if (isset($_REQUEST['des'])) {
            $p10 = explode(' ', '3 5 2 7 4 10 1 9 8 6');
            $p8 = explode(' ', '6 3 7 4 8 5 10 9');
            $p4 = explode(' ', '2 4 3 1');
            $ip = explode(' ', '2 6 3 1 4 8 5 7');
            $ep = explode(' ', '4 1 2 3 2 3 4 1');
            $s1 = [
                [1, 0, 3, 2],
                [3, 2, 1, 0],
                [0, 2, 1, 3],
                [3, 1, 3, 2]
            ];
            $s2 = [
                [0, 1, 2, 3],
                [2, 0, 1, 3],
                [3, 0, 1, 0],
                [2, 1, 0, 3]
            ];
            $plain_text = str_split(str_replace(' ', '', '1010 0101'));
            $key = str_split('0010010111');
            $des = new Des($p10, $p8, $p4, $ip, $ep, $s1, $s2, $plain_text, $key);

            # Generate Keys
            $keys = $des->get_keys();
            $key1 = $keys[0];
            $key2 = $keys[1];

            # IP[Plain Text]
            $pt_ip = $des->premutation($plain_text, $ip);
            $ipl = array_slice($pt_ip, 0, count($pt_ip) / 2);
            $ipr = array_slice($pt_ip, count($pt_ip) / 2);

            # Encryption - Round [1]
            $ipr_ep = $des->premutation($ipr, $ep);
            $ipr_ep_xor_key1 = $des->xor($ipr_ep, $key1);
            $ipr_s1 = array_slice($ipr_ep_xor_key1, 0, count($ipr_ep_xor_key1) / 2);
            $ipr_s2 = array_slice($ipr_ep_xor_key1, count($ipr_ep_xor_key1) / 2);
            $sbox = $des->get_sbox($ipr_s1, $ipr_s2);
            $sbox_p4 = $des->premutation($sbox, $p4);
            $sbox_p4_xor_ipl = $des->xor($sbox_p4, $ipl);

            # Swapping
            $ipl = $ipr;
            $ipr = $sbox_p4_xor_ipl;

            # Encryption - Round [2]
            $ipr_ep = $des->premutation($ipr, $ep);
            $ipr_ep_xor_key2 = $des->xor($ipr_ep, $key2);
            $ipr_s1 = array_slice($ipr_ep_xor_key2, 0, count($ipr_ep_xor_key2) / 2);
            $ipr_s2 = array_slice($ipr_ep_xor_key2, count($ipr_ep_xor_key2) / 2);
            $sbox = $des->get_sbox($ipr_s1, $ipr_s2);
            $sbox_p4 = $des->premutation($sbox, $p4);
            $sbox_p4_xor_ipl = $des->xor($sbox_p4, $ipl);
            $ipl = $sbox_p4_xor_ipl;

            # Final Permutation IP(-1)
            $cipher_text = $des->premutation(array_merge($ipl, $ipr), $ip);
            print_r($cipher_text);
        }
    }
?>