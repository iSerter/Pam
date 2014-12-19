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
 * Description of Parser
 *
 * @author Ilyas Serter <ilyasserter@gmail.com>
 */
class Parser {
    
    private $features = ['calculate' => '\Pam\Features\Calculator\Calculator', 
                        'fetch' => '\Pam\Features\Fetch\Fetch',
                        'run' => '\Pam\Features\Run\Run'
                        ];
    
    private $redundantWords = ['pam','please','?','!',',','.'];
    
    /**
     * 
     * @param type $input
     * @return boolean or 
     */
    public function determineFeature($input) {
        // clean input 
        $input = $this->cleanInput($input);
        // make sure input has 1+ words
        if(strstr($input, ' ') !== false) {
            // get first word to determine the task
            $words = explode(' ', $input);
            // loop through commands
            foreach($this->features as $key => $class) {
                if($key == $words[0]) {
                    return new $class($input);
                }
            }
        } 
                
        return false;
    }
    
    /**
     * 
     * @param string $input
     * @return string
     */
    private function cleanInput($input) {
        return trim(str_replace($this->redundantWords,'',strtolower($input)));
    }
    
    
    
}
