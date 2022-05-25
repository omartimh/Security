<?php
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
            $this->_ya = ($this->_p ** $this->_xa) % $this->_q;
            $this->_yb = ($this->_p ** $this->_xb) % $this->_q;
            
            # Calculate Same Keys
            $this->_a = ($this->_yb ** $this->_xa) % $this->_q;
            $this->_b = ($this->_ya ** $this->_xb) % $this->_q;

        }

        public function get_keys() {
            $keys = [$this->_ya, $this->_yb, $this->_a, $this->_b];
            return $keys;
        }
    }
?>