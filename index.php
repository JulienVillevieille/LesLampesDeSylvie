<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" media="screen and (min-width: 1199px)" href="css/nav.css">
        <link rel="stylesheet" media="screen and (max-width: 1199px)" href="css/navSmallScreen.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/fonts.css">
        <link rel="stylesheet" href="css/socialMediaIcons.css">
        <link rel="icon" href="images/favicon.ico">

        <!-- SOCIAL MEDIAS ICONS -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

        <title>Les Lampes de Sylvie - Accueil</title>

    </head>

    <body>
        <div id="main_body">

            <!-- HEADER -->
            <?php include("includes/header.php"); ?>

            <!-- NAV -->
            <?php include("includes/nav.php"); ?>

            <!-- BODY -->
            <div id="main_body_home">
                <br/>
                <div id="news" class="hidden_small_screen">
                    <h2>La Star du moment</h2>
                    <div id="news-content">
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

                            $reponse = $bdd->query('SELECT lt.name AS typeName, l.id, l.lamp_name, l.lamp_type, l.category, l.presentation_text, l.url_img_cover 
                                                    FROM lamps_types AS lt
                                                    INNER JOIN lamps AS l
                                                    ON lt.id_lamps = l.lamp_type
                                                    WHERE l.isInNews=1'
                                                    );
                            $donnees = $reponse->fetch();

                            ?>
                        <img src=<?php echo $donnees['url_img_cover']; ?> alt="<?php echo $donnees['lamp_name']; ?>" />
                        <div id="news-content-text">
                            <h4><?php echo $donnees['lamp_name']; ?></h4>
                            <p><img src="images/FriseLogo.PNG" alt="frise"></p>
                            <p><?php echo $donnees['typeName'] . ' - ' . $donnees['category']; ?></p>
                            <p><em><?php echo $donnees['presentation_text']; ?></em></p>
                            <a class="button_show_lamp" href="lampe?id=<?php echo $donnees['id']; ?>"><i class="far fa-eye"></i>Découvrez-moi !</a>
                        </div>
                        <?php
                            $reponse->closeCursor();
                        ?>
                    </div>
                </div>

                <div id="content_presentation">
                    <h2>La P'tite Histoire</h2>
                    
                    <div id="text_presentation">
                        <h3>Qui suis-je ?</h3>
                        <p><img src="images/FriseLogo.PNG" alt="frise"></p>
                        <p>
                            Installée aux Saintes Maries de La Mer, créatrice des Lampes de Sylvie depuis Janvier 2021, passionnée de bricolage et de récup', 
                            je crée, pour ma chambre des lampes de chevets. Suite aux encouragements de mes proches, je me lance dans l'aventure de la création 
                            artisanale de lampes.
                        </p>

                        <h3>Pourquoi des lampes ?</h3>
                        <p><img src="images/FriseLogo.PNG" alt="frise"></p>
                        <p>
                            La vie est lumineuse, et c'est très souvent la lumière qui nous montre les directions à prendre. Elle nous réchauffe les coeurs de son éclat, 
                            c'est un petit bout de soleil dans une ampoule.
                        </p>
                        <p>
                            Et en tant qu'artiste, je rajouterais :
                        </p>
                        <blockquote>"N'oubliez pas d'être un peu fêlé, pour faire passer la lumière."</blockquote>

                        <h3>Pourquoi du bois flotté ?</h3>
                        <p><img src="images/FriseLogo.PNG" alt="frise"></p>
                        <p>
                            Dotée d'une imagination débordante, amoureuse de la nature, c'est en regardant, ballade faisant, une branche de bois flotté, 
                            échue sur une plage de Camargue, que naquit cette idée lumineuse.
                        </p>
                        <p>
                            Pourquoi ne pas donner une seconde vie à ce bois chargé d'histoire ?
                        </p>
                        <p>
                            Ce bout de bois, lavé et drossé par le biais du vent, des courants, de l'eau salée et des marais...<br/>
                            Ce morceau d'arbre, qui a subi ces actions durant des mois, des années, qui l'ont rendu si rond, si doux, si poli.
                        </p>
                        <p>
                            Le mettre en lumière fut une évidence, le nettoyer, le sublimer, l'imaginer, le choyer, pour qu'il puisse "parler" de son histoire au sein d'un doux foyer.
                        </p>

                        <h3>Quelle technique ?</h3>
                        <p><img src="images/FriseLogo.PNG" alt="frise"></p>
                        <p>
                            Le choix des accessoires (ampoules, abat-jours, ...) se fait, soit sur un coup de coeur, soit pour venir transformer un morceau de bout de bois trouvé préalablement.
                            Dans le premier cas, le dilemme est de trouver le bois qui s'adaptera à l'accessoire.
                        </p>
                        <p>
                            Toutes les finitions sont faites à la main, encordages des cables éléctriques et des douilles.
                        </p>
                        <p>
                            Les composants éléctriques sont aux normes CE et toutes les lampes sont testées durant des jours afin d'assurer une sécurité optimale.
                        </p>
                        <p>
                            Les bois flottés sont nettoyés à l'eau douce, poncés légèrement et enduits d'une couche de vernis satiné incolore.
                        </p>
                        <p>
                            Ils sont fixés entre eux par des vis qui assurent leur solidité.
                        </p>

                        <h3>Pourquoi les bâptiser ?</h3>
                        <p><img src="images/FriseLogo.PNG" alt="frise"></p>
                        <p>
                            Afin de leur donner cette seconde vie, pour qu'elles fassent parti du foyer ou elles illumineront par leurs personnalités.
                        </p>
                        <p>
                            Et aussi, parce que c'est joli un petit nom, c'est personnel et c'est vivant.
                        </p>
                    </div>
                    <p id="frise"><img src="images/FriseLogo.PNG" alt="frise"></p>
                    <p id="conclusion">
                        Ainsi, les Lampes de Sylvie sont toutes uniques et vivantes.
                    </p>
                    <p id="etiquette">
                        <img src="images/etiquette.png" alt="Les Lampes de Sylvie" title="Les Lampes de Sylvie"/>
                    </p>
                </div>

            </div>
            
            <!-- FOOTER -->
            <?php include("includes/footer.php"); ?>
            
        </div>
    </body>
</html>