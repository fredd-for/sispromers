<?php
//session_start();
//if($_SESSION['session_gerente_acceso'] != "iniSession_gerente") {
//    header("Location: ../index.php");
//}
?>
<?php require_once('Connections/conexion.php'); ?>
<?php require("phpmailer/class.phpmailer.php"); //Importamos la función PHP class.phpmailer ?>
<?php
$mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        
        $mail->Host = "smtp.gmail.com"; // "mail.iteam.com.bo"; // 
        $mail->Username = "luis.freddy.velasco@gmail.com"; //"freddy.velasco@iteam.com.bo"; // sispromer@fh.org
        $mail->Password = "Josue1:8"; //8209125"; // Micah6:8
        $mail->Port = 465; // 25
        $mail->SMTPSecure = 'ssl';

        
        $mail->From = "luis.freddy.velasco@gmail.com"; // Desde donde enviamos (Para mostrar)
        
        /*
        $mail->Host = "mail.iteam.com.bo"; // ""; // 
        $mail->Username = "freddy.velasco@iteam.com.bo"; //""; // sispromer@fh.org
        $mail->Password = "8209125"; //"; // Micah6:8
        $mail->Port = 25; // 25
        $mail->From = "freddy.velasco@iteam.com.bo"; // Desde donde enviamos (Para mostrar)
        */
        
        
        $mail->FromName = "Sistema SISPROMERS";
        $mail->AddAddress("luis.freddy.velasco@gmail.com"); // Esta es la dirección a donde enviamos
        $mail->IsHTML(true); // El correo se envía como HTML
        $mail->Subject = "Registro satisfacorio"; // Este es el titulo del email.
        $body = "Usted se ha registrado correctamente<br />";
        $body .= "<strong>Usuario: </strong><br>";
        $body .= "<strong>Contrase&ntilde;a: </strong><br>";
        $body .= "Saludos, ";

        $mail->Body = $body; // Mensaje a enviar
        $mail->AltBody = "PRUEBA"; // Texto sin html
        
        if (!$mail->Send()) {
            echo "Error: " . $mail->ErrorInfo;
        } 
        else {
            echo "Email enviado correctamente" ;
        }
?>
