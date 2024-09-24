<?php

class RouteTest
{
    private $routes;

    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    public function testRoutes()
    {
        $count = 0;
        $success = 0;
        $failed = 0;
        foreach ($this->routes as $route => $controllerMethod) {
            $count++;
            list($controller, $method) = explode('/', $controllerMethod);

            $controllerClass = ucfirst($controller); 

            if(! file_exists("app/controller/".$controllerClass.".php")){
                echo "❌ Controller $controllerClass for route '$route' :: '$controllerMethod' does not exist.\n";
                $failed++;
                continue;
            }
            else{
                include_once "app/controller/".$controllerClass.".php";
                if (!class_exists($controllerClass)) {
                    echo "❌ Class $controllerClass for route '$route' :: '$controllerMethod' does not exist.\n";
                    $failed++;
                    continue;
                }
    
                if (!method_exists($controllerClass, $method)) {
                    echo "❌ Function '$method' in route '$route' :: '$controllerMethod' does not exist.\n";
                    $failed++;
                    continue;
                }
            }
            



            echo "✅ ROUTE: '$route' :: '$controllerMethod' is valid.\n";
            $success++;
        }
        echo "\nValidates $count routes.\n$success success.\n$failed failed.\n";
    }
}


?>