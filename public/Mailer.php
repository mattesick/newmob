<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'].'../vendor/autoload.php';
function sendMail($toEmail, $toName, $subject, $html)
{

    include_once "ChromePhp.php";
    $host = fopen($_SERVER['DOCUMENT_ROOT'] . "/mail.env", "r") or die("Unable to open file!");
    $file = fread($host, filesize($_SERVER['DOCUMENT_ROOT'] . "/mail.env"));
    $lines = explode(PHP_EOL, $file);

    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;                  
        $mail->isSMTP();                       
        $mail->Host       = 'smtp.gmail.com';  
        $mail->SMTPAuth   = true;                      
        $mail->Username = 'palmeusjs@gmail.com';
        $mail->Password = $lines[0];

        // $mail->Username = 'noreply@mobelkillarna.se';
        // $mail->Password = $lines[0];

        // $mail->Username   = 'jafaraliwork14@gmail.com';
        // $mail->Password   = $lines[2];   
        $mail->SMTPSecure = 'tls';           
        $mail->Port       = 587;    
        $mail->setFrom('palmeusjs@gmail.com', 'Linus Jansson');
        $mail->addAddress($toEmail);

            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $html;
            $mail->send(); 
            return true;
            // echo "Message Sent OK\n";
        } catch (phpmailerException $e) {
            return false;
            // echo $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
            return false;
            // echo $e->getMessage(); //Boring error messages from anything else!
        }
    }
