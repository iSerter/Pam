<?php namespace Pam\Intelligence;

/*
 * The MIT License
 *
 * Copyright 2014 Ilyas Serter <ilyasserter@gmail.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */


/**
 * A simple class to handle Pam's core functions.
 *
 * @author Ilyas Serter <ilyasserter@gmail.com>
 */
class Intelligence implements IntelligenceInterface {

    private $parser;
    private $inputs = array();
    private $outputs = array();
    
    function __construct() {
        $this->parser = new Parser;
    }

    /**
     * listens for input 
     * 
     * @param string $input
     * @return boolean
     */
    public function listen($input = null) {
        if(!is_null($input) && trim($input) != 'exit') {
            $this->inputs[] = $input;
            return true;
        }
        
        return false;
    }
    
    /**
     * Handles the last input
     * @TODO develop the communication feature to remember old inputs. 
     * 
     */
    protected function think() {
        $input = end($this->inputs);
        if($feature = $this->parser->determineFeature($input)) {
           $this->outputs[] = $feature->run();
        } else {
            // fallback to communication feature. 
            $feature = new \Pam\Features\Communication\Communication($input);
            // I really should have thought this thorough in the beginning. 
            $this->outputs[] = $feature->run();
        }
    }
    
    /**
     * 
     * @return string
     */
    public function respond() {
        $this->think(); // gotta think before saying anything. 
        return end($this->outputs);
    }
    
    public function sayHello() {
        return 'Hi there!';
    }
}
