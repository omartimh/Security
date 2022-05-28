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