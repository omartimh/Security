<?php

    function findRandomPrime() {
        $min = 2;
        $max = 212; // 2147483647
        for ($i = rand($min, $max); $i < $max; $i++) {
            if (isPrime($i)) {
                return $i;
            }
        }
    }

    function isPrime($num){
        if($num % 2 == 0) {
            return false;
        }
            
        for($i = 3; $i <= ceil(sqrt($num)); $i = $i + 2) {
            if($num % $i == 0)
                return false;
        }
        return true;
    }

    class Des {
        private $_plaintext;
        private $_key;      # Key
        private $_key1;     # Key [1]
        private $_key2;     # Key [2]
        private $_p10;      # P10
        private $_p8;       # P8
        private $_p4;       # P4
        private $_ip;       # IP
        private $_ep;       # EP

        public function __construct($plain_text, $key, $p10, $p8, $p4, $ip, $ep) {
            $this->_plain_text = $plain_text;
            $this->_key = $key;
            $this->_p10 = $p10;
            $this->_p8 = $p8;
            $this->_p4 = $p4;
            $this->_ip = $ip;
            $this->_ep = $ep;
        }

        public function get_keys($k1, $k2) {
            # K1 & K2 ===> P10 -- nenady 3ala premutation
            # K1 Left Shift 1-bit
            # K2 Left Shift 3-bit
            # K1 & K2 ===> P8 -- nenady 3ala premutation
            $this->_key1 = 1;
            $this->_key2 = 1;
            return 0;
        }

        public function premutation($p, $n) {
            $arr = [];
            for ($i = 0; $i < count($n); $i++) {
                array_push($arr, $n[$p[$i] - 1]);
            }
            $k = left_shift(1, $arr);
        }

        public function left_shift($shift, $n) {
            $k = $n << $shift;
            return $k;
        }
    }

    class DiffieHellman {

        # Prime Numbers - Defined
        private $_p = 0;
        private $_q = 0;
    
        # Private Keys for Alice and Bob - Defined
        private $_xa = 0;
        private $_xb = 0;

        # Public Keys for Alice and Bob - Calculated
        private $_ya = 0;
        private $_yb = 0;

        # Same Keys for Alice and Bob - Calculated
        private $_a = 0;
        private $_b = 0;

        public function __construct($p, $q, $xa, $xb) {
            $this->_p = $p;
            $this->_q = $q;
            $this->_xa = $xa;
            $this->_xb = $xb;
            
            # Calculate Public Keys
            $this->_ya = abs(($this->_p ** $this->_xa) % $this->_q);
            $this->_yb = abs(($this->_p ** $this->_xb) % $this->_q);
            # $this->_ya = bcpowmod($this->_p, $this->_xa, $this->_q);
            # $this->_yb = bcpowmod($this->_p, $this->_xb, $this->_q);
            
            # Calculate Same Keys
            $this->_a = abs(($this->_yb ** $this->_xa) % $this->_q);
            $this->_b = abs(($this->_ya ** $this->_xb) % $this->_q);
            # $this->_ya = bcpowmod($this->_yb, $this->_xa, $this->_q);
            # $this->_ya = bcpowmod($this->_ya, $this->_xb, $this->_q);

        }

        public function get_keys() {
            $keys = [$this->_ya, $this->_yb, $this->_a, $this->_b];
            return $keys;
        }
    }
?>