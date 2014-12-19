<?php namespace Pam\Features\Run;

class Run implements \Pam\FeatureInterface{

    private $parser;
    private $command;

    function __construct($input) {
        $this->parser = new CommandParser();
        $this->command = $this->parser->parse($input);
    }

    public function run() {
        
    }

}