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

        $directory = 'php/controller/*.php'; 

        $files = glob($directory);
        $filenames = [];
        foreach ($files as $file) {
            $filenames[]=substr(basename($file), 0, -4);
        }
        foreach ($this->routes as $route => $controllerMethod) {
            $count++;
            $exp = explode('/', $controllerMethod);
            $controller = $exp[0];
            $method = isset($exp[1]) ? $exp[1] : "index";

            $controllerClass = ucfirst($controller); 
            
            if(in_array(ucfirst($route), $filenames)){
                $uc = ucfirst($route);
                echo "❌ Route name '$route' conflicts with Controller name '$uc' .\n";
                $failed++;
                continue;
            }
            else if(strtolower($route)=="public" || strtolower($route)=="api" ||  strtolower($route)=="app" || strtolower($route)=="views"){
                $loweroute = strtolower($route);
                echo "❌ Route: '$loweroute', $loweroute is a case sensitive name, might cause errors.\n";
                $failed++;
                continue;
            }
            else if(! file_exists("php/controller/".$controllerClass.".php")){
                echo "❌ Controller $controllerClass for route '$route' :: '$controllerMethod' does not exist.\n";
                $failed++;
                continue;
            }
            else{
                include_once "php/controller/".$controllerClass.".php";
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