<?php


if(! function_exists("email_template")){
    function email_template(string $email_template, array $content=[]){
        $YROS = &Yros::get_instance();
        return $YROS->yrosmail->email_template($email_template, $content);
    }
}

if(! function_exists("send_email")){
    function send_email(string $receiver_email, string $subject, $message, string $sender_name = "", string $sender_email=""): array{
        $YROS = &Yros::get_instance();
        return $YROS->yrosmail->send_email($receiver_email,$subject, $message, $sender_name,$sender_email);
    }
}
?>