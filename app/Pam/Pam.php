<?php namespace Pam;


use Pam\Intelligence\Intelligence;

/**
 * Pam, my silly assistant for fun development environment.
 *
 * @author Ilyas Serter <ilyasserter@gmail.com>
 */
class Pam extends Intelligence {
    
    private $name = 'Pam';

    public function sayHello() {
        return "Hello! I'm {$this->name}, and you?";
    }
}
