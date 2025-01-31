<?php
class Middleware {

    public static function check(string $middlewarefile, callable $function) {
            $currentController = $_SESSION['yros_p4ge_contr0ll3r_1005055_v13w5'];
            $protectedControllers = self::loadMiddlewaresFromFile($middlewarefile);
            if (in_array($currentController, $protectedControllers)) {
                $function();exit;
            }
        }

    public static function except(string $middlewarefile, callable $function) {
        $currentController = $_SESSION['yros_p4ge_contr0ll3r_1005055_v13w5'];
        $protectedControllers = self::loadMiddlewaresFromFile($middlewarefile);
        if (! in_array($currentController, $protectedControllers)) {
            $function();exit;
        }
    }

    public static function loadMiddlewaresFromFile($file) {
            if (!file_exists("app/middlewares/".$file)) {
                return []; 
            }
            $file = "app/middlewares/".$file;
        
            $middlewares = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            return array_map('trim', $middlewares); 
        }
}

?>