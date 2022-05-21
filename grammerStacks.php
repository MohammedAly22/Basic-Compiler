<?php
    class Stack
    {
        protected $stack;
        protected $size;
        
        public function __construct($size = 50) {
            $this->stack = array();
            $this->size  = $size;
        }
        
        /**
         * Insert an element in a stack
         * @param type $data
         */
        public function push($data) {
            if(count($this->stack) < $this->size) {
                array_unshift($this->stack, $data);
            }
            else{
                throw new RuntimeException("Stack overflow");
            }
        }
        
        public function pop() {
            if (empty($this->stack)){    
                throw new RuntimeException("Stack underflow");
            } 
            else{
                return array_shift($this->stack);
            }
        }
    
        public function emptyStack(){
            if (empty($this->stack)){    
                return true;
            }
            else{
                return false;
            }
        }

        public function clearStack(){
            $this->size  = 0;
        }
    }
?>