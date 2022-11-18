<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

    class FunctionsSendEmail {

        public static function sendEmail ($email, $usuario_token) {

            $mail = new PHPMailer(true);

			try {
				//Server settings
				$mail->SMTPDebug = false;                      //Enable verbose debug output
				$mail->isSMTP();                                          //Send using SMTP
				$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
				$mail->SMTPAuth   = true;                                 //Enable SMTP authentication
				// O seu e-mail que enviará a mensagem
				$mail->Username   = 'gustavoferreira.png@gmail.com';      //SMTP username
				// A senha para aplicativos externos, para usar o SMTP
				$mail->Password   = 'wyjktuzbpxkqkenl';                   //SMTP password
				$mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
				$mail->Port       = 587;              //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

				// Email e nome do remetente
				$mail->setFrom('gustavoferreira.png@gmail.com', 'Gustavo Ferreira');
				// Email do destinatário
				$mail->addAddress($email);     //Add a recipient

				//Contéudo
				$mail->isHTML(true);                             //Set email format to HTML
				$mail->Subject = 'Token Twitter Clone';
				$mail->Body    = '<h2>Seu token de verificação é: ' . $usuario_token . '<h2>';
				$mail->AltBody = 'É necessário utilizar um client que suporte HTML para ter acesso total ao conteúdo dessa mensagem.';

				$mail->send();
			} catch (\Exception $e) {
				$mail->ErrorInfo;
			}
		}
            
        

    }

?>