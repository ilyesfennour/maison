<?php
use PHPMailer\PHPMailer\PHPMailer;

require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';

$mail = new PHPMailer();
                    
$mail->isSMTP();                                            
$mail->Host       = 'smtp.gmail.com';                     
$mail->SMTPAuth   = true;                                   
$mail->Username   = 'ilyeeees220@gmail.com';                     
$mail->Password   = 'if08122003';                               
$mail->SMTPSecure = 'ssl';            
$mail->Port       = 465; 

$mail->isHTML(true);
$mail->charset = "UTF-8";
?>