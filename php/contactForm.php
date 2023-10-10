<?php
    if($_POST) 
    {
        session_start();
        $_SESSION['sendMessage'] = FALSE;

        $visitor_name = "";
        $visitor_email = "";
        $visitor_tel = "";
        $email_title = "";
        $visitor_message = "";
        $email_body = "<div>";
        
        if(isset($_POST['visitor_name'])) 
        {
            $visitor_name = filter_var($_POST['visitor_name'], FILTER_SANITIZE_STRING);
            $email_body .= "<div>
                            <label><b>Nom :</b></label>&nbsp;<span>".$visitor_name."</span>
                            </div><br/>";
        }
    
        if(isset($_POST['visitor_email'])) 
        {
            $visitor_email = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['visitor_email']);
            $visitor_email = filter_var($visitor_email, FILTER_VALIDATE_EMAIL);
            $email_body .= "<div>
                            <label><b>Adresse Mail :</b></label>&nbsp;<span>".$visitor_email."</span>
                            </div><br/>";
        }

        if(isset($_POST['visitor_tel'])) 
        {
            $visitor_tel = filter_var($_POST['visitor_tel'], FILTER_SANITIZE_STRING);
            $email_body .= "<div>
                            <label><b>N° de téléphone :</b></label>&nbsp;<span>".$visitor_tel."</span>
                            </div><br/>";
        }
        
        if(isset($_POST['email_title'])) 
        {
            $email_title = filter_var($_POST['email_title'], FILTER_SANITIZE_STRING);
            $email_body .= "<div>
                            <label><b>Sujet :</b></label>&nbsp;<span>".$email_title."</span>
                            </div><br/>";
        }

        if(isset($_POST['visitor_message'])) 
        {
            $visitor_message = htmlspecialchars($_POST['visitor_message']);
            $email_body .= "<div>
                            <label><b>Message :</b></label>
                            <div>".$visitor_message."</div>
                            </div><br/>";
        }
        
        $recipient = "contact@leslampesdesylvie.fr";

        $email_body .= "<p>Vous avez reçu ce message via leslampesdesylvie.fr</p></div>";
    
        $headers  = 'MIME-Version: 1.0' . "\r\n"
        .'Content-type: text/html; charset=utf-8' . "\r\n"
        .'From: ' . $recipient . "\r\n";
        
        if(mail($recipient, "Vous avez reçu un message d'un visiteur web - leslampesdesylvie.fr", $email_body, $headers)) 
        {
            $_SESSION['sendMessage'] = TRUE;
        } 
        else 
        {
            $_SESSION['sendMessage'] = FALSE;
        }
    }

    header('Location: ../contact');
?>