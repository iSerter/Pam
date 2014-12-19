<?php namespace Pam\Features\Run;

/**
 * @TODO develop a feature to run tasks?? Not yet sure what kind those tasks will be. 
 */
class Run implements \Pam\FeatureInterface {

    private $parser;
    private $command;

    function __construct($input) {
        $this->parser = new CommandParser();
        $this->command = $this->parser->parse($input);
    }

    public function run() {
        
    }

}