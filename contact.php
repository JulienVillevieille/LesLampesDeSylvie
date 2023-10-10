<?php 
    session_start();
?>

<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/contact.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" media="screen and (min-width: 1199px)" href="css/nav.css">
        <link rel="stylesheet" media="screen and (max-width: 1199px)" href="css/navSmallScreen.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/fonts.css">
        <link rel="stylesheet" href="css/socialMediaIcons.css">
        <link rel="icon" href="images/favicon.ico">

        <!-- SOCIAL MEDIAS ICONS -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

        <title>Les Lampes de Sylvie - Contact</title>

    </head>

    <body>
        <div id="main_body">

            <!-- HEADER -->
            <?php include("includes/header.php"); ?>

            <!-- NAV -->
            <?php include("includes/nav.php"); ?>

            <div id="main_body_contact">
                <h2>Nos Conditions</h2>
                <p>Pour une commande minimale de 100€ - Livraison gratuite dans un rayon de 100 km. Au-delà nous consulter.</p><br/>
                <p>Réservation avec accompte de 30%</p><br/><br/>
                <p>Pour les expéditions (<strong>Uniquement pour les P'tites Lampes</strong> - <span class="warning">Pas d'expéditions pour les autres types de lampes</span>):</p><br/>
                <ul>
                    <li>Frais de port à la charge du client</li>
                    <li>Envoie des réception du réglement (virement)</li>
                </ul>

                <h2>Nous Contacter</h2>
                <br/>
                <p>Afin de répondre au mieux à vos attentes, nous avons besoin que vous remplissiez les informations suivantes :</p>
                <div id="contact_form">
                    <form action="php/contactForm.php" method="post">
                        <div class="elem-group">
                            <label for="name">Votre Nom<em>*</em></label>
                            <input type="text" id="name" name="visitor_name" placeholder="Nom Prénom" pattern=[A-Z\sa-z-]{3,20} required>
                        </div>
                        <div class="elem-group">
                            <label for="email">Votre Adresse Mail<em>*</em></label>
                            <input type="email" id="email" name="visitor_email" placeholder="adresse@mail.com" required>
                        </div>
                        <div class="elem-group">
                            <label for="tel">Votre Numéro de Téléphone<em>*</em></label>
                            <input type="tel" id="tel" name="visitor_tel" placeholder="06 00 00 00 00" pattern=(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4} required>
                        </div>
                        <div class="elem-group">
                            <label for="title">Sujet<em>*</em></label>
                            <?php if(isset($_GET['id']))
                                {
                                    $_GET['id'] = (int) $_GET['id'];
                                    if($_GET['id'] > 0)
                                    {
                                        try
                                        {
                                            $bdd = new PDO('mysql:host=localhost;dbname=leslampesdesylvie;charset=utf8', 'root' , 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                                            // $bdd = new PDO('mysql:host=db5002459610.hosting-data.io;dbname=dbs1961658;charset=utf8', 'dbu1377283' , 'vegasylvie13!', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                                        }
                                        catch (Exception $e)
                                        {
                                            die('Erreur : ' . $e->getMessage());
                                        }
                                        
                                        $reponse = $bdd->query('SELECT lamp_name, price, isPromo, pricePromo FROM lamps WHERE id='. $_GET['id']);
                                        $donnees = $reponse->fetch();
                                    }
                                }

                                if(isset($donnees['lamp_name']) AND isset($donnees['price']) AND isset($donnees['isPromo']) AND isset($donnees['pricePromo']))
                                {
                                    switch($donnees['isPromo'])
                                    {
                                        case 1:
                                            $subject = $donnees['lamp_name'] . ' - En Promotion - ' . $donnees['pricePromo'] . '€';
                                            break;
                                        case 0:
                                        default:
                                            $subject = $donnees['lamp_name'] . ' - ' . $donnees['price'] . '€';
                                    }
                                    ?>
                                <?php
                                }
                                else
                                {
                                    $subject = "";
                                }
                            ?>

                            <input type="text" id="title" name="email_title" required placeholder="Sujet" pattern=[A-Za-z0-9\s-€]{4,100} value="<?php echo $subject; ?>" <?php if($subject != "") {echo "readonly='readonly'";}?>>

                        </div>
                        <div class="elem-group">
                            <label for="message">Écrivez-votre message<em>*</em></label>
                            <textarea id="message" name="visitor_message" placeholder="Message" required></textarea>
                        </div>
                        <p><em>*</em>Champs obligatoires.</p>
                        <button type="submit"><i class="fas fa-envelope-open-text"></i>Envoyez Votre Message</button>
                        <?php
                            if(isset($_SESSION['sendMessage']))
                            {
                                if($_SESSION['sendMessage'])
                                {
                                    echo("<p class='message_send'>Votre message a bien été envoyé !</p>");
                                    $_SESSION['sendMessage'] = false;
                                }
                            }
                        ?>
                      </form>
                </div>
            </div>
            
            <!-- FOOTER -->
            <?php include("includes/footer.php"); ?>

        </div>
    </body>
</html>