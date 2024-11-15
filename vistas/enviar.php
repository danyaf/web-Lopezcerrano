<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';
    require 'PHPMailer/Exception.php';

    header("Location:about.html");


    //Create an instance; passing `true` enables exceptions
    $mailResAu = new PHPMailer(true);  //Se crea instancia para respuesta automatica de recibido
    $mail = new PHPMailer(true);       //Se crea instancia para respuesta a lopezserrano dnde ahi si viaja el mensaje

    try {
        //Server settings PARA MANDAR RESPUESTA AUTOMATICA DE RECIBIDO CON MENSAGE PERSONALIZADO DE RECIBIDO
        $mailResAu->SMTPDebug = 0;                      //Enable verbose debug output
        $mailResAu->isSMTP();                                            //Send using SMTP
        $mailResAu->Host       = 'mail.lopezserrano.com';                     //Set the SMTP server to send through
        $mailResAu->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mailResAu->Username   = 'contacto@lopezserrano.com';                     //SMTP username
        $mailResAu->Password   = 'C0nt4ct0-*+';                               //SMTP password
        $mailResAu->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mailResAu->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


        //ESTE ES EL CORREO PIVOTE QUE MANDARA OTRO CORREO PERO AL PERSONAL PARA EL TRATO DIRECTO CON EL CLIENTE
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.lopezserrano.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'contacto@lopezserrano.com';                     //SMTP username
        $mail->Password   = 'C0nt4ct0-*+';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;  

        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $mensaje = $_POST['mensaje'];
        $asunto = $_POST['asunto'];

        //Recipients
        $mailResAu->setFrom('contacto@lopezserrano.com', 'Atencion LOPEZSERRANO');
        $mailResAu->addAddress($email, $nombre);     //Add a recipient
       // $mailResAu->addCC('danyaf.dta@gmail.com');

        //Recipients A DONDE SE MANDARA EL MSJ DEL USUARIO Q ME CONTACTO
        $mail->setFrom('contacto@lopezserrano.com', 'te manda msj: ' . $nombre . ' ' . $email ); //a quien le llegara el correo
        $mail->addAddress('francisco@lopezserrano.com', $nombre);     //Add a recipient
       // $mail->addCC('danyaf.dta@gmail.com');

        /*//Attachments
        $mailResAu->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        $mailResAu->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name*/

        //Content
        $mailResAu->isHTML(true);                                  //Set email format to HTML
        $mailResAu->Subject =  $asunto;
        $mailResAu->Body    = 'LOPEZSERRANO le agradece el ponerse en contacto con nosotros, hemos recibido su petición y nosotros nos pondremos en contacto con usted mas adelante.';

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject =  $asunto;
        $mail->Body    = 'Te quiere contactar  ' . $nombre . ' con el siguiente mensaje :  '  .  $mensaje;

        $mailResAu->send(); //enviar msj respuesta automatica
        $mail->send(); //enviar msj a lopes con el msj del cliente
        echo 'Message has been sent';

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mailResAu->ErrorInfo}";
    }






    
 /*   $mail = new HPMailer();
    $mailR = new PHPMailer();*/


    /*$mail->SMTPOptions = array(
        ´ssl´ => array(
            ´verify_peer´ => false,
            ´verify_peer_name´ => false,
            ´allow_self_signed´ => true
        )
    );*/


    /*$mail->IsSMTP();            //indico a la clase que use SMTP
    $mailR->IsSMTP(); 
    
    $mail->SMTPDebug = 2;       //permite modo debug para ver mensajes de las cosasque van ocurriendo
    $mail->SMTPAuth = true;     //Debo de hacer autenticaci贸n SMTP
    $mail->SMTPSecure = "ssl";

    $mailR->SMTPDebug = 2;       //permite modo debug para ver mensajes de las cosasque van ocurriendo
    $mailR->SMTPAuth = true;     //Debo de hacer autenticaci贸n SMTP
    $mailR->SMTPSecure = "ssl";
    
    $mail->Host = "mail.lopezserrano.com"; //indico el servidor de Gmail para SMTP
    $mail->Port = 465;  //indico el puerto que usa

    $mailR->Host = "mail.lopezserrano.com"; //indico el servidor de Gmail para SMTP
    $mailR->Port = 465;  //indico el puerto que usa 
    
    $mail->Username = "contacto@lopezserrano.com"; //indico un usuario / clave de un usuario de gmail
    $mail->Password = "C0nt4ct0-*+";
    $mail->SetFrom('contacto@lopezserrano.com', 'Atencion LOPEZSERRANO');

    $mailR->Username = "contacto@lopezserrano.com"; //indico un usuario / clave de un usuario de gmail
    $mailR->Password = "C0nt4ct0-*+";
    $mailR->SetFrom('contacto@lopezserrano.com', 'Atencion LOPEZSERRANO');
    
    $address = "danyaf.dta@gmail.com"; //indico destinatario
    $mail->AddAddress($address, "dany Rey");
    
    $nombre = $_POST['nombre'];
	$email = $_POST['email'];
	$mensaje = $_POST['mensaje'];
	$asunto = $_POST['asunto'];
	
	$mail->AddReplyTo($email , $nombre);
	$mail->MsgHTML($mensaje);
    $mail->Subject = ($asunto);

    if (!$mail->send()) {
            $msg = 'Sorry, something went wrong. Please try again later.';
    } else {
        $msg = 'Message sent! Thanks for contacting us.';
        $mailR->AddAddress($email , $nombre);
        $mailR->MsgHTML("LOPEZSERRANO le agradece el ponerse en contacto con nosotros, hemos recibido su petición y nosotros nos pondremos en contacto con usted mas adelante.");
        $mailR->Subject = ($asunto);
        if(!$mailR->send()){
            $msg = 'Sorry, something went wrong. Please try again later.';
        }
    }*/
?>