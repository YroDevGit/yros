

<?php
require "app/system/lib/PHPMailer/src/PHPMailer.php";
require 'app/system/lib/PHPMailer/src/SMTP.php';
require 'app/system/lib/PHPMailer/src/Exception.php';

// Use PHPMailer namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Yros_mail{
    public $mail;
    public function __construct()
	{
        require_once "app/config/email_config.php";
		$this->mail = new PHPMailer(true);
        $this->mail->isSMTP();                                           
        $this->mail->Host       = $email_config['smtp_host'];                       
        $this->mail->SMTPAuth   = true;                                   
        $this->mail->Username   = $email_config['smtp_user'];              
        $this->mail->Password   = $email_config['smtp_password'];                     
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
        $this->mail->Port       = $email_config['smtp_port'];    
	}

    public function email_template(string $email_template, array $content=[]) {
        $template = "views/emails/".$email_template.".php";
        if (file_exists($template)) {
            if(! empty($content)){
                extract($content);
            }
            ob_start(); 
            include $template;
            $message = ob_get_clean(); 
            return $message;
        } else {
            return false;
        }
    }

    public function send_email(string $to, string $subject, &$message, string $sender="", string $sender_email=""){
        if(has_internet_connection()){
            if($message){
                try {
                    include "app/config/email_config.php";
                    $e_sender = $sender=="" ? $email_config['default_sender_name'] : $sender;
                    $e_sendemail = $sender_email=="" ? $email_config['default_sender_email'] : $sender_email;
                    $this->mail->setFrom($e_sendemail, $e_sender);      
                    $this->mail->addAddress($to, $to);   
                
                    // Content
                    $this->mail->isHTML(true);                                       
                    $this->mail->Subject = $subject;                     
                    $this->mail->Body    = $message;  
                    $this->mail->AltBody = 'This is the plain text body';           
                
                    $this->mail->send();
                    return ["code"=>200, "status"=>"success", "message"=>"Email sent successfully", "sender"=>$e_sender, "receiver"=>$to, "sender_email"=>$e_sendemail];
                } catch (Exception $e) {
                    return ["code"=>-1, "status"=>"error", "message"=>$this->mail->ErrorInfo];
                }
            }
            else{
                return ["code"=>404, "Message Not Found", "message"=>"Email Message Not Found.!"];
            }
        }
        else{
            return ["code"=>-1, "status"=>"No Internet Connection", "message"=>"Email not sent, No internet connection"];
        }
        
    }
}



?>