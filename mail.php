<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer"s autoloader
require "vendor/autoload.php";

$mail = new PHPMailer(true);                              
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 
    $mail->isSMTP();                                     
    $mail->Host = "smtp.gmail.com";  
    $mail->SMTPAuth = true;                               
    $mail->Username = "jkizito@intervas.com";                
    $mail->Password = "Catherine256$";                          
    $mail->SMTPSecure = "tls";                         
    $mail->Port = 587;                                   

    //Recipients
    $mail->setFrom("jkizito@intervas.com", "Mailer");
    $mail->addAddress("jkizito@intervas.com", "Jovan User");    
    $mail->addReplyTo("jkizito@intervas.com", "Information");    

    //Content
    $mail->isHTML(true);                                  
    $mail->Subject = "Here is the subject";
    $mail->Body    = "This is the HTML message body <b>in bold!</b>";
    $mail->AltBody = "This is the body in plain text for non-HTML mail clients";

    $mail->send();
    echo "Message has been sent";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: ", $mail->ErrorInfo;
}

?>