<?php

//Email settings
$email_config['protocol'] = getenv("EMAIL_PROTOCOL");
$email_config['smtp_host'] = getenv("EMAIL_HOST");
$email_config['smtp_port'] = getenv("EMAIL_PORT");
$email_config['smtp_user'] = getenv("EMAIL_USER");
$email_config['smtp_password'] = getenv("EMAIL_PASSWORD");
$email_config['mail_type'] = getenv("EMAIL_TYPE");
$email_config['charset'] = getenv("EMAIL_CHARSET");

//send email settings
$email_config['default_sender_name'] = getenv("EMAIL_SENDER");
$email_config['default_sender_email'] = getenv("EMAIL_ADD");


?>