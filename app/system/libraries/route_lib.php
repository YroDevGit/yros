<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Route_lib{
    public function __construct()
	{
		
	}


    public function getRoute(string $route){
        include "app/system/functions/myroutes.php";
        if(array_key_exists($route, $routes)){
            return controller($route);
        }
        else{
            trigger_error(display_error("Route name: '$route' not found.!"));
        }

    }
}
    ?>