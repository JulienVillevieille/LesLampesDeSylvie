<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/lampPresentation.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" media="screen and (min-width: 1199px)" href="css/nav.css">
        <link rel="stylesheet" media="screen and (max-width: 1199px)" href="css/navSmallScreen.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/fonts.css">
        <link rel="stylesheet" href="css/socialMediaIcons.css">
        <link rel="icon" href="images/favicon.ico">

        <!-- SOCIAL MEDIAS ICONS -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

        <title>Les Lampes de Sylvie - Suspensions et Appliques</title>

    </head>

    <body>
        <div id="main_body">

            <!-- HEADER -->
            <?php include("includes/header.php"); ?>

            <!-- NAV -->
            <?php include("includes/nav.php"); ?>

            <!-- BODY -->
            <div id="main_body_presentation_lamp">

                <h2>Les Suspensions et Appliques</h2>

                <div id="presentation_lamp">
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

                        $reponse = $bdd->query('SELECT lt.name AS typeName, l.id as lampId, l.lamp_name as lampName, l.isAvailable as isAvailable, l.isPromo as isPromo, l.presentation_text as lampPres, l.url_img_cover as lampImg
                                                FROM lamps_types AS lt
                                                INNER JOIN lamps as l
                                                ON lt.id_lamps = l.lamp_type
                                                WHERE isOnline=1 AND (l.lamp_type=1 OR l.lamp_type=2) 
                                                ORDER BY l.isPromo AND l.isAvailable DESC, l.isAvailable DESC, l.id DESC
                                                ');

                        while($donnees = $reponse->fetch())
                        {
                            ?>
                            <div class="lampAppAndSusp">
                                <h3><?php echo $donnees['lampName']; ?></h3>
                                <p class="lamp_type"><?php echo $donnees['typeName']; ?></p>
                                <p>
                                    <a href="lampe?id=<?php echo $donnees['lampId']; ?>" title="Découvrez <?php echo $donnees['lampName'] ?> !">
                                        <img class="contour" src="images/ropeFrame.png" alt=<?php echo $donnees['lampName']; ?> />
                                        <img class="img_lamp" src=<?php echo $donnees['lampImg']; ?> alt=<?php echo $donnees['lampName']; ?> />
                                    </a>
                                </p>
                                <p class="state_sold_<?php echo($donnees['isAvailable'] ? ($donnees['isPromo'] ? "onPromo" : "on") : "off")?>"><?php echo $donnees['isAvailable'] ? ($donnees['isPromo'] ? "EN PROMOTION" : "DISPONIBLE") : "VENDUE"; ?></p>
                                <p class="lamp_pres_text">
                                    <?php echo $donnees['lampPres']; ?>
                                </p><br/>
                                <a class="button_show_lamp" href="lampe?id=<?php echo $donnees['lampId']; ?>"><i class="far fa-eye"></i>Découvrez-moi</a>
                            </div>
                            <?php
                        }
                        $reponse->closeCursor();
                    ?>
                </div>
            </div>
            
            <!-- FOOTER -->
            <?php include("includes/footer.php"); ?>
            
        </div>
    </body>
</html>