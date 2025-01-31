<?php
function log_msg($message, string $label = "LOG"){
    if(is_array($message)){
        file_put_contents("app/logs/".date("Y-m-d"), $label.": ".json_encode($message));
    }else{
        file_put_contents("app/logs/".date("Y-m-d"), $label.": ".$message);
    }
}
?>