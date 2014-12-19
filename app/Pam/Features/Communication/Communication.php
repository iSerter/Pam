<?php namespace Pam\Features\Communication;

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
 * Not sure where this silly class is going.
 * It's crazy simple and totally unreliable : )
 * 
 * @author Ilyas Serter <ilyasserter@gmail.com>
 */
class Communication implements \Pam\FeatureInterface  {
    
    private $input;
    
    // I so need a better way to store these. But let's just have this to complete enough features for unit testing.
    private $vocabulary = [
                            'hi' => 'Hi, how can I help you?',
                            'hello' => 'Hi, how can I help you?',
                            'how are you' => "Thank you for asking. I'm doing excellent. How may I serve you?",
                            'who are you?' => "I am a silly computer program, servant,and a friend if you will."
                            
        ];
    
    private $redundantInput = ['pam','please','?','!',',','.'];
    
    public function __construct($input) {
        $this->input = $this->cleanInput($input);
    }

    /**
     * Definitely needs a better way to understand. 
     * @TODO utilize regular expressions to understand the input rather than relying on array keys.
     * @TODO come up with a better way to understand input. also remember old inputs.
     * @return string
     */
    public function run() {
        if(key_exists($this->input, $this->vocabulary)) {
            return $this->vocabulary[$this->input];
        } else {
            return "Sorry, my features are very limited and I don't understand you. " . PHP_EOL 
                . " Please read my manual for the featues I'm capable of.";
        }
    }
    
    public function cleanInput($input) {
        return trim(str_replace($this->redundantInput,'',strtolower($input)));
    }

}