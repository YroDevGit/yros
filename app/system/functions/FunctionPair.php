<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class FunctionPair {
    private static $functionCalled = [];
    private static $rollbackRequested = false;

    public static function pair($firstFunc, $secondFunc) {
        if (!isset(self::$functionCalled[$firstFunc])) {
            self::$functionCalled[$firstFunc] = false;
        }
        if (!isset(self::$functionCalled[$secondFunc])) {
            self::$functionCalled[$secondFunc] = false;
        }
    }

    public static function callFirst($firstFunc, $secondFunc) {
        self::$functionCalled[$firstFunc] = true;
        self::$rollbackRequested = false;
        
        register_shutdown_function(function() use ($secondFunc) {
            if (!self::$functionCalled[$secondFunc]) {
                self::$rollbackRequested = true;
                trigger_error("The paired function '$secondFunc'() was not called!", E_USER_ERROR);
            }
        });
    }

    public static function callSecond($secondFunc) {
        self::$functionCalled[$secondFunc] = true;
        if (self::$rollbackRequested) {
            self::performRollback();
        }
    }

    private static function performRollback() {
        $YROS = &Yros::get_instance();
        if ($YROS->db->inTransaction()) {
            $YROS->db->rollback(); 
        }
    }
}

?>