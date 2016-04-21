<?php
require "mailer/class.phpmailer.php"; 
include "mailer/class.smtp.php";

class Mail{
	public static function send($to , $message , $subject){

	   	$mail         		= new PHPMailer();
	        $mail->IsSMTP();
	        $mail->isHTML(true);
	        $mail->SMTPAuth   = true;
	        $mail->Host       = "smtp.gmail.com";
	        $mail->Port       = 465;
	        $mail->Username   = "hubertnoyessie";
	        $mail->Password   = "alpha2.0";
	        $mail->SMTPSecure = 'ssl';
	        $mail->SetFrom('hubertnoyessie@gmail.com', 'NeoSoft Developpeur');
	        $mail->AddReplyTo("hubertnoyessie@gmail.com","NeoSoft Developpeur");
	        $mail->Subject    = $subject;
	        $mail->AltBody    = "Any message.";
	        $mail->MsgHTML($message);
	        $mail->AddAddress($to, "Destinataire");
	        if(!$mail->Send()) {
	            echo "Mail non envoye";
	            return 0;
	        } else {
	            echo "Mail envoyé";
	              return 1;
	       }

// $mail             = new PHPMailer();
//         $body             = "enfin";
//         $mail->IsSMTP();
//         $mail->SMTPAuth   = true;
//         $mail->Host       = "smtp.gmail.com";
//         $mail->Port       = 465;
//         $mail->Username   = "hubertnoyessie";
//         $mail->Password   = "alpha2.0";
//         $mail->SMTPSecure = 'ssl';
//         $mail->SetFrom('hubertnoyessie@gmail.com', 'Developpeur');
//         $mail->AddReplyTo("hubertnoyessie@gmail.com","Developpeur");
//         $mail->Subject    = "subject";
//         $mail->AltBody    = "Any message.";
//         $mail->MsgHTML($body);
//         $address = "hubertnoyessie@gmail.com";
//         $mail->AddAddress($address, "Destinataire");
//         if(!$mail->Send()) {
//             echo "Mail non envoye";
//             return 0;
//         } else {
//             echo "Mail envoyé";
//               return 1;
//        }
// 	   unset($mail);
 	}
}