<?php namespace Pam\Features\Fetch;

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
 * Heavily inspired by Jeffrey Way's PHPUnit tutorial.
 *
 * @author Ilyas Serter <ilyasserter@gmail.com>
 */
class Fetch implements \Pam\FeatureInterface {
    
    private $assets = ['backbone' => 'http://backbonejs.org/backbone-min.js',
                    'jquery' => 'http://code.jquery.com/jquery.js',
                    'normalize' => 'https://raw.githubusercontent.com/necolas/normalize.css/master/normalize.css',
                    'underscore' => 'http://underscorejs.org/underscore.js'
                ];
    
    private $asset;
    private $save = false;
    
    
    function __construct($input) {
        $this->parse($input);
    }
    
    // run the feature
    public function run() {
        
        if(key_exists($this->asset, $this->assets)) {
            $content = file_get_contents($this->assets[$this->asset]);
            /**
             * @TODO implement save feature 
             */
            return $content;
        }
        
        return $this->asset . " is not recognized.";
    }
    
    // parse input..
    private function parse($input) {
       if(strstr($input,'save') !== false) 
               $this->save = true;
       
       $this->asset = trim(str_replace(['fetch','and save','save'],'',$input));
    }
}
