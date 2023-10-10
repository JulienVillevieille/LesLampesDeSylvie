<?php
    // Vérification que l'id récupéré par GET a une correspondance dans la BDD
    if(isset($_GET['id'])) // Variable existe
    {
        $_GET['id'] = (int) $_GET['id']; // Conversion en entier

        // Ouverture de la BDD
        try
        {
            $bdd = new PDO('mysql:host=localhost;dbname=leslampesdesylvie;charset=utf8', 'root' , 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            // $bdd = new PDO('mysql:host=db5002459610.hosting-data.io;dbname=dbs1961658;charset=utf8', 'dbu1377283' , 'vegasylvie13!', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }

        $reponse = $bdd->query('SELECT id, lamp_name, isOnline FROM lamps');

        $isGoodID = false;

        while($donnees = $reponse->fetch() AND $isGoodID == false)
        {
            if($donnees['id'] == $_GET['id']) // On vérifie que l'id a bien une correspondance dans la BDD
            {
                if($donnees['isOnline'] == 1) // On vérifie que cette lampe est bien censé être en ligne
                {
                    $isGoodID = true; // L'ID récupéré par GET est correct, on peux donc continuer normalement le traitement.

                    $userLampID = $_GET['id']; // On stocke l'iD
                    $userLampName = $donnees['lamp_name']; // On stocke le nom
                }
            }                
        }

        $reponse->closeCursor();

        if(!$isGoodID) // Si l'id n'a pas de correspondance, on recharge l'accueil
        {
            header('Location: index');
        }
    }
    else // Si la variable n'existe pas, on recharge l'accueil
    {
        header('Location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">

        <link href="lightbox2-2.11.3/src/css/lightbox.css" rel="stylesheet" />

        <link rel="stylesheet" href="css/lampTechnical.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" media="screen and (min-width: 1199px)" href="css/nav.css">
        <link rel="stylesheet" media="screen and (max-width: 1199px)" href="css/navSmallScreen.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/fonts.css">
        <link rel="stylesheet" href="css/socialMediaIcons.css">
        <link rel="icon" href="images/favicon.ico">

        <!-- SOCIAL MEDIAS ICONS -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

        <title>Les Lampes de Sylvie - Lampe <?php echo $userLampName; ?></title>
       
    </head>

    <body>
        <div id="main_body">

            <!-- HEADER -->
            <?php include("includes/header.php"); ?>

            <!-- NAV -->
            <?php include("includes/nav.php"); ?>

            <!-- BODY -->
            <div id="main_body_presentation_technical_lamp">
                <?php
                    try
                    {
                        $bdd = new PDO('mysql:host=localhost;dbname=leslampesdesylvie;charset=utf8', 'root' , 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                        // $bdd = new PDO('mysql:host=db5002459610.hosting-data.io;dbname=dbs1961658;charset=utf8', 'dbu1377283' , 'vegasylvie13!', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                    }
                    catch (Exception $e)
                    {
                        die('Erreur : ' . $e->getMessage());
                    }
                    
                    $reponse = $bdd->query('SELECT lt.name AS typeName, l.id, l.lamp_name, l.category, l.presentation_text, l.technical_text, l.height, l.width, l.depth, l.price, l.isPromo, l.pricePromo, l.isAvailable, l.url_img_1, l.url_img_2, l.url_img_3, l.url_img_4, l.url_img_lamp_on, l.url_img_lamp_off
                                            FROM lamps_types AS lt
                                            INNER JOIN  lamps AS l
                                            ON lt.id_lamps = l.lamp_type
                                            WHERE l.id='. $userLampID 
                                            );
                    $donnees = $reponse->fetch();
                ?>

                <h2><?php echo $donnees['typeName'] . " - " . $donnees['lamp_name']; ?></h2>

                <div id="presentation_technical_lamp">

                    <div id="main_lamp_presentation">

                        <div id="all_text_presentation">
                            <div id="first_step_presentation">
                                <h3><?php echo $donnees['lamp_name']; ?></h3>
                                <p><strong>Catégorie</strong> : <?php echo $donnees['category'] ?></p>
                                <p><?php echo $donnees['presentation_text']; ?></p>
                                <?php // AFFICHE PRIX SI LAMPE TOUJOURS DISPO SINON AFFICHE QU'ELLE EST NON DISPO
                                    if($donnees['isAvailable'])
                                    {
                                        // Vérifie si la lampe n'est pas en promotion
                                        if(!$donnees['isPromo'])
                                        {
                                            ?>
                                            <p class="lamp_price_text"><!--Prix : --><?php echo $donnees['price']; ?> €</p>
                                            <?php
                                        }
                                        else // Si oui affiche les textes correspondants
                                        {
                                            ?>
                                            <p class="text_announce_promo">Cette lampe est en promotion !</p><br/>
                                            <p class="lamp_promo_price_text"><!--Prix : --><?php echo $donnees['price']; ?> €</p>
                                            <p class="lamp_promo_price_promo_text"><!--Prix : --><?php echo $donnees['pricePromo']; ?> €</p>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                        <p class="lamp_not_available_text">Cette lampe n'est plus disponible.</p>
                                        <?php
                                    }
                                ?>
                                <?php 
                                    if($donnees['isAvailable'])
                                    { 
                                        ?>
                                            <br/>
                                            <a class="button_contact" href="contact?id=<?php echo $donnees['id']; ?>" title="Contactez-nous à propos de <?php echo $donnees['lamp_name']; ?> !">
                                                <i class="fas fa-envelope-open-text"></i>Intéressé ? Des questions ? Contactez-nous !
                                            </a>
                                        <?php
                                    }
                                ?>

                            </div>

                            <div id="second_step_presentation">
                                <h4>Caractéristiques</h4>
                                <p><strong>Hauteur</strong> : <?php echo $donnees['height']; ?> cm</p>
                                <p><strong>Profondeur</strong> :  <?php echo $donnees['depth']; ?> cm</p>
                                <p><strong>Largeur</strong> : <?php echo $donnees['width']; ?> cm</p>
                                <br/>
                                <p>
                                    <?php 
                                        $tech_text = str_replace('.', '.<br/><br/>', $donnees['technical_text']);
                                        $tech_text = str_replace('CE', "<img class='ce_img' src='images/normCE.png' alt='Norme CE' />", $tech_text);
                                        echo $tech_text;
                                    ?>
                                    
                            </div>
                        </div>
                        
                        <div id="lamp_lighted">
                            

                            <img id="imageTurnOnOffLamp" src=<?php echo $donnees['url_img_lamp_off'] ?>  alt=<?php echo $donnees['lamp_name']; ?> onclick="turnOnOffLamp();"/><br/>
                            <p class="button_turn_off_on_lamp" onclick="turnOnOffLamp();"><i id="iconeBulb" class="far fa-lightbulb"></i>On / Off</p>

                            <script>
                                var srcLampOn = <?php echo json_encode($donnees['url_img_lamp_on']) ?>;
                                var srcLampOff = <?php echo json_encode($donnees['url_img_lamp_off']) ?>;

                                function turnOnOffLamp()
                                {
                                    var imgLamp = document.getElementById("imageTurnOnOffLamp");
                                    var srcImgLamp = imgLamp.getAttribute("src");

                                    var iconeBulb = document.getElementById("iconeBulb");
                                    var classBulb = iconeBulb.getAttribute("class");

                                    if(srcImgLamp == srcLampOff)
                                    {
                                        srcImgLamp = srcLampOn;
                                        classBulb = "fas fa-lightbulb lighted"
                                    }
                                    else
                                    {
                                        srcImgLamp = srcLampOff;
                                        classBulb = "far fa-lightbulb"
                                    }
                                    imgLamp.setAttribute("src", srcImgLamp);
                                    iconeBulb.setAttribute("class", classBulb);
                                }
                            </script>
                        </div>
                    </div>
                </div>

                <p class="presentation_photos">
                    <a href=<?php echo $donnees['url_img_1']; ?> data-lightbox="lamp_group"> 
                        <img src=<?php echo $donnees['url_img_1']; ?> alt=<?php echo $donnees['lamp_name']; ?> title="<?php echo $donnees['lamp_name'] . ' 1'; ?>" />
                    </a>
                    <a href=<?php echo $donnees['url_img_2']; ?> data-lightbox="lamp_group"> 
                        <img src=<?php echo $donnees['url_img_2']; ?> alt=<?php echo $donnees['lamp_name']; ?> title="<?php echo $donnees['lamp_name'] . ' 2'; ?>" />
                    </a>
                    <a href=<?php echo $donnees['url_img_3']; ?> data-lightbox="lamp_group"> 
                        <img src=<?php echo $donnees['url_img_3']; ?> alt=<?php echo $donnees['lamp_name']; ?> title="<?php echo $donnees['lamp_name'] . ' 3'; ?>" />
                    </a>
                    <a href=<?php echo $donnees['url_img_4']; ?> data-lightbox="lamp_group"> 
                        <img src=<?php echo $donnees['url_img_4']; ?> alt=<?php echo $donnees['lamp_name']; ?> title="<?php echo $donnees['lamp_name'] . ' 4'; ?>" />
                    </a>
                </p>
                   
                <?php
                    $lampName = $donnees['lamp_name'];
                    $reponse->closeCursor();
                ?>
            </div>
            
            <!-- FOOTER -->
            <?php include("includes/footer.php"); ?>
            
        </div>

        <script src="lightbox2-2.11.3/dist/js/lightbox-plus-jquery.js"></script>

        <script>
            lightbox.option({
                albumLabel: "<?php echo $lampName; ?> - %1 / %2",
                disableScrolling: true
            })
        </script>

    </body>
</html>