<?php
    class Des {
        private $_p10;
        private $_p8;
        private $_p4;
        private $_ip;
        private $_ep;
        private $_s1;
        private $_s2;
        private $_plaintext;
        private $_key;

        public function __construct($p10, $p8, $p4, $ip, $ep, $s1, $s2, $plain_text, $key) {
            $this->_p10 = $p10;
            $this->_p8 = $p8;
            $this->_p4 = $p4;
            $this->_ip = $ip;
            $this->_ep = $ep;
            $this->_s1 = $s1;
            $this->_s2 = $s2;
            $this->_plain_text = $plain_text;
            $this->_key = $key;
        }

        public function premutation($n, $p) {
            $array = array_fill(0, count($p), '');
            for ($i = 0; $i < count($array); $i++) {
                $array[$i] = $n[$p[$i] - 1];
            }
            return $array;
        }

        public function left_shift($n, $shift) {
            for ($i = 0; $i < count($n) - 1; $i++){
                for ($j = 0; $j < $shift; $j++) {
                    array_unshift($n, array_pop($n));
                }
            }
            return $n;
        }

        public function xor($n, $k) {
            $array = [];
            $i = 0;
            $j = 0;
            while ($i < count($n)) {
                if ($n[$i] == $k[$j]) {
                    array_push($array, '0');
                } else {
                     array_push($array, '1');
                }
                $i++;
                $j++;
            }
            return $array;
        }

        public function get_sbox($ipr_s1, $ipr_s2) {
            $bin_row1 = $ipr_s1[0] . $ipr_s1[3];
            $bin_col1 = $ipr_s1[1] . $ipr_s1[2];
            $bin_row2 = $ipr_s2[0] . $ipr_s2[3];
            $bin_col2 = $ipr_s2[1] . $ipr_s2[2];

            $row1 = bindec($bin_row1);
            $col1 = bindec($bin_col1);
            $row2 = bindec($bin_row2);
            $col2 = bindec($bin_col2);

            $s1 = decbin($this->_s1[$row1][$col1]);
            $s2 = decbin($this->_s2[$row2][$col2]);
            
            if (strlen($s1) == 1) {
                $s1 = '0' . $s1;
            }
            if (strlen($s2) == 1) {
                $s2 = '0' . $s2;
            }

            $sbox = str_split($s1 . $s2);
            return $sbox;
        }

        public function get_keys() {
            $key_p10 = $this->premutation($this->_key, $this->_p10);
            $k1 = array_slice($key_p10, 0, count($key_p10) / 2);
            $k2 = array_slice($key_p10, count($key_p10) / 2);

            $shift1 = 1;
            $shift3 = 3;
            $k11 = $this->left_shift($k1, $shift1);
            $k12 = $this->left_shift($k2, $shift1);
            $k31 = $this->left_shift($k1, $shift3);
            $k32 = $this->left_shift($k2, $shift3);
            $key1_ls = array_merge($k11, $k12);
            $key2_ls = array_merge($k31, $k32);
            $key1_p8 = $this->premutation($key1_ls, $this->_p8);
            $key2_p8 = $this->premutation($key2_ls, $this->_p8);

            $keys = [$key1_p8, $key2_p8];
            return $keys;
        }
    }
?>