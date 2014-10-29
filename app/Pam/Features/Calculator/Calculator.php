<?php namespace Pam\Features\Calculator;

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
 * Description of Calculator
 *
 * @author Ilyas Serter <ilyasserter@gmail.com>
 */
class Calculator implements \Pam\FeatureInterface {
    
    private $expression;
    private $math;
    
    function __construct($input) {
        // initiate Math object
        $this->math = new Math;
        // parse given input to an expression
        $this->parse($input);
    }
    
    // run method
    public function run() {
        return $this->math->evaluate($this->expression);
    }
    
    // parse input 
    private function parse($input) {
       $input = trim(str_replace(['calculate','plus','minus','times','divided by'],['','+','-','*','/'],$input));
       $this->expression = preg_replace('#[^0-9\+\-\*\/\(\)]#', '', $input); 
    }
    
}
