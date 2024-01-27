<?php

namespace app\components;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Messanger {

    const EMAIL_HOST        = 'smtp.spaceweb.ru';
    const EMAIL_USERNAME    = 'base@dozorsystem.ru';
    const EMAIL_PASSWORD    = 'Base1010';

    public static function sendEmail(string $subject, array $recipients, array $files, string $body)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = self::EMAIL_HOST;                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = self::EMAIL_USERNAME;                     // SMTP username
            $mail->Password   = self::EMAIL_PASSWORD;                               // SMTP password
            $mail->Port       = 465;                                    // TCP port to connect to
            $mail->CharSet    = 'utf-8';
            //Recipients
            $mail->setFrom(self::EMAIL_USERNAME, 'DozorSystem');

            foreach ($recipients as $recipient)
            {
                $mail->addAddress($recipient);     // Add a recipient
            }

            $mail->addReplyTo(self::EMAIL_USERNAME);

            // Attachments
            foreach ($files as $file)
            {
                $mail->addAttachment($file);         // Add attachments
            }

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();

            return true;

        } catch (Exception $e) {

            return false;
        }
    }

    public static function sendMessageToTelegramm($chat_id, $message)
    {
        try {
            TelegramAPI::sendMessage($chat_id, $message);
            return true;
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public static function sendMessageToICQ($chat_id, $message)
    {
        try {
            IcqAPI::sendMessage($chat_id, $message);
            return true;
        }
        catch (\Exception $e)
        {
            return false;
        }
    }
}
