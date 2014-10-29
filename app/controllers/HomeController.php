<?php

use Pam\Pam;

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function welcome()
	{
            $pam = new Pam();
            echo $pam->sayHello(); 
            echo PHP_EOL . ' <hr />' . PHP_EOL;

            // do math
            $pam->listen('Pam, please calculate 7*3+5');
            echo $pam->respond();
            
            echo PHP_EOL . ' <hr />' . PHP_EOL;
            
            // fetch stuff
            $pam->listen('Pam, fetch normalize!');
            echo $pam->respond();
            
            echo PHP_EOL . ' <hr />' . PHP_EOL;

	}

}
