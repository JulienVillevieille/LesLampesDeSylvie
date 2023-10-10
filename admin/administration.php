<?php
    session_start();
?>

<?php
    if(isset($_POST['userID']) AND isset($_POST['userPassword']))
    {
        try
        {
            $bdd_users = new PDO('mysql:host=localhost;dbname=leslampesdesylvie;charset=utf8', 'root' , 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            // $bdd = new PDO('mysql:host=db5002459610.hosting-data.io;dbname=dbs1961658;charset=utf8', 'dbu1377283' , 'vegasylvie13!', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }

        $req = $bdd_users->prepare('SELECT id, pseudo FROM admin_members WHERE userID = :userID AND userPassword = :userPassword');

        $req->execute(array(
            'userID' => $_POST['userID'],
            'userPassword' => $_POST['userPassword']
        ));

        $resultat = $req->fetch();

        if(!$resultat)
        {
            $_SESSION['wrongUserID'] = true;
            $_SESSION['isConnected'] = false;
            header('Location: login.php');
        }
        else
        {
            $_SESSION['id'] = $resultat['id'];
            $_SESSION['pseudo'] = $resultat['pseudo'];
            $_SESSION['isConnected'] = true;
        }
    }
    else if(isset($_SESSION['id']) AND isset($_SESSION['pseudo']))
    {
        $_SESSION['isConnected'] = true;
    }
    else
    {
        $_SESSION['isConnected'] = false;
        header('Location: login.php');
    }

    if($_SESSION['isConnected'])
    {
?>
    <!DOCTYPE html>
    <html lang="fr">

        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="../css/administration.css">
            <link rel="stylesheet" href="../css/header.css">
            <link rel="stylesheet" href="../css/fonts.css">
            <link rel="icon" href="../images/favicon.ico">

            <!-- ICONS -->
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

            <title>Les Lampes de Sylvie - Administration</title>

            <script type="text/javascript">
                function resetForm()
                {
                    document.getElementById('online-select').value = '-1';
                    document.getElementById('buy-select').value = '-1';
                    document.getElementById('type-select').value = '-1';
                    document.getElementById('minPrice-input').value = 0;
                    document.getElementById('maxPrice-input').value = 5000;
                    document.getElementById('name-input').value = "";
                    document.getElementById('promo-select').value = '-1';
                }
            </script>

        </head>

        <body>
            <div id="main_body">

                <!-- HEADER -->
                <header>
                    <p id="header_image_logo">
                        <img src="../images/header_logo.png" alt="Les Lampes de Sylvie" title="Les Lampes de Sylvie" />
                    </p>
                </header>

                <div class="separator"></div>

                <!-- BODY -->
                <div id="main_body_home">

                    <h2>Administration</h2>

                    <p class="welcome_msg">
                        Bienvenue sur la page d'administration <?php echo $_SESSION['pseudo']; ?>.
                    </p>

                    <?php
                        if(isset($_SESSION['lampCreated']) AND isset($_SESSION['message']) AND $_SESSION['message'] != "")
                        {
                            if($_SESSION['lampCreated'] == true)
                            {
                                ?>
                                <p class="goodMessage"><i class="fas fa-check-double"></i><?php echo $_SESSION['message'] ?></p>
                                <?php
                            }
                            else
                            {
                                ?>
                                <p class="badMessage"><i class="fas fa-exclamation-triangle"></i><?php echo $_SESSION['message'] ?></p>
                                <?php
                            }
                            
                            $_SESSION['message'] = "";
                            $_SESSION['lampCreated'] = false;
                        } 
                    ?>

                    <div class="section_actions">
                        <h3>Actions</h3>
                        <span class="button_actions">
                            <a href="addNewLamp.php"><i class="fas fa-plus-circle"></i>Ajouter une nouvelle Lampe</a>
                        </span>
                        <span class="button_actions">
                            <a href="../index.php" target="_blank"><i class="far fa-eye"></i>Visiter le site</a>
                        </span>
                    </div>

                    <form id="main_form" action="administration.php" method="post">

                    <h3>Système de Tri et Recherches</h3>

                        <div id="input-select-form">
                            <span>  <!-- SPAN SELECT isOnline -->
                                <label for="online-select">Lampe en ligne ?</label>
                                <select name="isOnline" id="online-select">
                                    <option value="-1" 
                                        <?php 
                                            if(isset($_POST['isOnline']))
                                            {
                                                if($_POST['isOnline'] != 0 AND $_POST['isOnline'] != 1)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                            }
                                        ?>
                                    >Peu importe</option>
                                    <option value="0"
                                    <?php 
                                            if(isset($_POST['isOnline']))
                                            {
                                                if($_POST['isOnline'] == 0)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                            }
                                        ?>
                                    >Hors Ligne</option>
                                    <option value="1"
                                    <?php 
                                            if(isset($_POST['isOnline']))
                                            {
                                                if($_POST['isOnline'] == 1)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                            }
                                        ?>
                                    >En ligne</option>
                                </select>
                            </span>

                            <span> <!-- SPAN SELECT isAvailable-->
                                <label for="buy-select">Lampe vendue ?</label>
                                <select name="isAvailable" id="buy-select">
                                    <option value="-1"  
                                        <?php 
                                            if(isset($_POST['isAvailable']))
                                            {
                                                if($_POST['isAvailable'] != 0 AND $_POST['isAvailable'] != 1)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                            }
                                        ?>
                                    >Peu importe</option>
                                    <option value="0" 
                                        <?php 
                                            if(isset($_POST['isAvailable']))
                                            {
                                                if($_POST['isAvailable'] == 0)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                            }
                                        ?>
                                    >Vendue</option>
                                    <option value="1"
                                        <?php 
                                            if(isset($_POST['isAvailable']))
                                            {
                                                if($_POST['isAvailable'] == 1)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                            }
                                        ?>
                                    >Non vendue</option>
                                </select>
                            </span>

                            <span> <!-- SPAN SELECT Type-->
                                <?php // OUVERTURE DE LA BDD
                                    try
                                    {
                                        $bdd = new PDO('mysql:host=localhost;dbname=leslampesdesylvie;charset=utf8', 'root' , 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                                        // $bdd = new PDO('mysql:host=db5002459610.hosting-data.io;dbname=dbs1961658;charset=utf8', 'dbu1377283' , 'vegasylvie13!', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                                    }
                                    catch (Exception $e)
                                    {
                                        die('Erreur : ' . $e->getMessage());
                                    }

                                    $reponse = $bdd->query('SELECT id_lamps, lt.name AS lamp_type_name
                                                            FROM lamps_types AS lt
                                                            ORDER BY id_lamps
                                                            ');
                                ?>

                                <label for="type-select">Type</label>
                                <select name="lampType" id="type-select">
                                    <option value="-1" 
                                        <?php 
                                            if(isset($_POST['lampType']))
                                            {
                                                if($_POST['lampType'] < 1 AND $_POST['isOnline'] > 4)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                            }
                                        ?>   
                                        >Peu importe</option>
                                    <?php
                                        while($donnees = $reponse->fetch())
                                        {
                                            ?>

                                            <option value="<?php echo $donnees['id_lamps']; ?>"
                                                <?php 
                                                    if(isset($_POST['lampType']))
                                                    {
                                                        if($_POST['lampType'] == $donnees['id_lamps'])
                                                        {
                                                            echo "selected=\"selected\"";
                                                        }
                                                    }
                                                ?>    
                                            >
                                                <?php echo $donnees['lamp_type_name']; ?> 
                                            </option>
                                            
                                            <?php
                                        }

                                        $reponse->closeCursor();
                                    ?>
                                </select>
                            </span>

                            <span>  <!-- SPAN INPUT Min Price -->
                                <label for="minPrice-input">Prix Minimum (en €)</label>
                                <input type="number" name="minPrice" id="minPrice-input" min="0" value=
                                    <?php 
                                        if(isset($_POST['minPrice']))
                                        {
                                            $_POST['minPrice'] = (int) $_POST['minPrice'];
                                            echo $_POST['minPrice'];
                                        }
                                        else
                                        {
                                            echo "0";
                                        }
                                    ?>    
                                >
                            </span>

                            <span>  <!-- SPAN INPUT Max Price -->
                                <label for="maxPrice-input">Prix Maximum (en €)</label>
                                <input type="number" name="maxPrice" id="maxPrice-input" min="0" value=
                                    <?php 
                                        if(isset($_POST['maxPrice']))
                                        {
                                            $_POST['maxPrice'] = (int) $_POST['maxPrice'];
                                            echo $_POST['maxPrice'];
                                        }
                                        else
                                        {
                                            echo "5000";
                                        }
                                    ?>
                                >
                            </span>

                            <span>  <!-- SPAN INPUT Name -->
                                <label for="name-input">Nom</label>
                                <input type="text" name="name" id="name-input" placeholder="Recherche par nom" value=
                                    <?php 
                                            if(isset($_POST['name']))
                                            {
                                                $_POST['name'] = strip_tags($_POST['name']);
                                                echo $_POST['name'];
                                            }
                                        ?>
                                >
                            </span>

                            <span>  <!-- SPAN SELECT isPromo -->
                                <label for="promo-select">Lampe en Promotion ?</label>
                                <select name="isPromo" id="promo-select">
                                    <option value="-1" 
                                        <?php 
                                            if(isset($_POST['isPromo']))
                                            {
                                                if($_POST['isPromo'] != 0 AND $_POST['isPromo'] != 1)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                            }
                                        ?>
                                    >Peu importe</option>
                                    <option value="0"
                                    <?php 
                                            if(isset($_POST['isPromo']))
                                            {
                                                if($_POST['isPromo'] == 0)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                            }
                                        ?>
                                    >Non</option>
                                    <option value="1"
                                    <?php 
                                            if(isset($_POST['isPromo']))
                                            {
                                                if($_POST['isPromo'] == 1)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                            }
                                        ?>
                                    >Oui</option>
                                </select>
                            </span>
                        </div>

                        <span>
                            <button type="submit" value="search"><i class="fas fa-search"></i>Rechercher</button>
                        </span>

                        <span>
                            <button type="button" value="reset" onclick='resetForm()' ><i class="fas fa-undo-alt"></i>Réinitialiser</button>
                            
                            
                        </span>
                        
                    </form>

                    

                    <div id="all_lamps_line_presentation">

                        <?php // OUVERTURE DE LA BDD
                            try
                            {
                                $bdd = new PDO('mysql:host=localhost;dbname=leslampesdesylvie;charset=utf8', 'root' , 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                                // $bdd = new PDO('mysql:host=db5002459610.hosting-data.io;dbname=dbs1961658;charset=utf8', 'dbu1377283' , 'vegasylvie13!', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                            }
                            catch (Exception $e)
                            {
                                die('Erreur : ' . $e->getMessage());
                            }
                            
                            if(isset($_POST['isOnline'])
                            AND isset($_POST['isAvailable'])
                            AND isset($_POST['lampType'])
                            AND isset($_POST['minPrice'])
                            AND isset($_POST['maxPrice'])
                            AND isset($_POST['name'])
                            )
                            {
                                $req = 'SELECT lt.name AS typeName, l.id AS lampId, l.lamp_name, l.isOnline, l.category, l.height, l.width, l.depth, l.price, l.isPromo, l.pricePromo, l.isInNews, l.isAvailable, l.url_img_1 
                                        FROM lamps_types AS lt
                                        INNER JOIN lamps AS l
                                        ON lt.id_lamps = l.lamp_type';

                                // FILTRE ONLINE
                                switch($_POST['isOnline']) 
                                {
                                    case 0:
                                        $req = $req . ' WHERE (l.isOnline = 0)';
                                        break;
                                    case 1:
                                        $req = $req . ' WHERE (l.isOnline = 1)';
                                        break;
                                    default:
                                        $req = $req . ' WHERE (l.isOnline = 0 OR l.isOnline = 1)';
                                        break;
                                }

                                // FILTRE VENDUE
                                switch($_POST['isAvailable'])
                                {
                                    case 0:
                                        $req = $req . ' AND (l.isAvailable = 0)';
                                        break;
                                    case 1:
                                        $req = $req . ' AND (l.isAvailable = 1)';
                                        break;
                                    default:
                                        $req = $req . ' AND (l.isAvailable = 0 OR l.isAvailable = 1)';
                                        break;
                                }

                                // FILTRE TYPE
                                switch($_POST['lampType'])
                                {
                                    case 1:
                                        $req = $req . ' AND (l.lamp_Type = 1)';
                                        break;
                                    case 2:
                                        $req = $req . ' AND (l.lamp_Type = 2)';
                                        break;
                                    case 3:
                                        $req = $req . ' AND (l.lamp_Type = 3)';
                                        break;
                                    case 4:
                                        $req = $req . ' AND (l.lamp_Type = 4)';
                                        break;
                                    default:
                                        $req = $req . ' AND (l.lamp_Type = 1 OR l.lamp_Type = 2 OR l.lamp_Type = 3 OR l.lamp_Type = 4)';
                                        break;
                                }

                                // FILTRE PRIX MIN
                                $_POST['minPrice'] = (int) $_POST['minPrice']; // On force la conversion en nombre entier
                                $req = $req . ' AND (l.price >= ' . $_POST['minPrice'] . ')';

                                // FILTER PRIX MAX
                                $_POST['maxPrice'] = (int) $_POST['maxPrice']; // On force la conversion en nombre entier
                                $req = $req . ' AND (l.price <= ' . $_POST['maxPrice'] . ')';

                                // FILTRE NOM
                                $_POST['name'] = strip_tags($_POST['name']);
                                if($_POST['name'] != "")
                                {
                                    $req = $req . ' AND (l.lamp_name = \'' . $_POST['name'] . '\')';
                                }

                                // FILTRE PROMOTION
                                switch($_POST['isPromo']) 
                                {
                                    case 0:
                                        $req = $req . ' AND (l.isPromo = 0)';
                                        break;
                                    case 1:
                                        $req = $req . ' AND (l.isPromo = 1)';
                                        break;
                                    default:
                                        $req = $req . ' AND (l.isPromo = 0 OR l.isPromo = 1)';
                                        break;
                                }

                                $req = $req . ' ORDER BY l.id DESC';
                                $reponse = $bdd->query($req);
                            }
                            else
                            {
                                $reponse = $bdd->query('SELECT lt.name AS typeName, l.id AS lampId, l.lamp_name, l.isInNews, l.isOnline, l.category, l.height, l.width, l.depth, l.price, l.isPromo, l.pricePromo, l.isAvailable, l.url_img_1
                                                        FROM lamps_types AS lt
                                                        INNER JOIN  lamps AS l
                                                        ON lt.id_lamps = l.lamp_type
                                                        ORDER BY l.id DESC
                                                        ');
                            }
                            
                        ?>

                        <table>
                            <thead>
                                <tr>
                                    <td>Photo</td>
                                    <td>Nom / Prix</td>
                                    <td>Type / Catégorie</td>
                                    <td>État</td>
                                    <td>Dimensions</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    while($donnees = $reponse->fetch())
                                    {
                                        ?>
                                        <tr class="lamp_line_presentation">
                                            <td class="lamp_line_photo <?php echo $donnees['isOnline'] ? 'online' : 'offline'; ?>">
                                                <img src= <?php echo $donnees['url_img_1']; ?> alt=<?php echo $donnees['lamp_name']; ?> />
                                            </td>
                                            <td class="lamp_line_content_text <?php echo $donnees['isOnline'] ? 'online' : 'offline'; ?>">
                                                <p class="lamp_line_content_name"><strong>Nom</strong> : <?php echo $donnees['lamp_name']; ?></p>
                                                <p><strong>Prix</strong> : <?php echo $donnees['price']; ?> €</p>
                                                <?php if($donnees['isPromo']){ ?> <p><strong>Prix Promo</strong> : <?php echo $donnees['pricePromo']; ?> €</p> <?php } ?>
                                            </td>
                                            <td class="lamp_line_content_text <?php echo $donnees['isOnline'] ? 'online' : 'offline'; ?>">
                                                <p><strong>Type</strong> : <?php echo $donnees['typeName']; ?></p>
                                                <p><strong>Catégorie</strong> : <?php echo $donnees['category']; ?></p>
                                            </td>
                                            <td class="lamp_line_content_text <?php echo $donnees['isOnline'] ? 'online' : 'offline'; ?>">
                                                <p class="<?php if(!$donnees['isAvailable']) {echo "lamp_isSold";}?>"> <!-- Si vendue affichage class vendue -->
                                                    <strong>Vendue</strong> : <?php echo $donnees['isAvailable'] ? "Non" : "Oui"; ?>
                                                </p>
                                                <p><strong>En ligne</strong> : <?php echo $donnees['isOnline'] ? "Oui" : "Non"; ?></p>
                                                <p><i class="fas fa-dollar-sign"></i> <strong>En promotion</strong> : <?php echo $donnees['isPromo'] ? "Oui" : "Non"; ?></p>
                                                <?php if($donnees['isInNews']) { ?>
                                                    <p><i class="fas fa-star"></i> <strong>Lampe Star</strong> : <?php echo $donnees['isInNews'] ? "Oui" : "Non"; ?></p>
                                                <?php } ?>
                                            </td>
                                            <td class="lamp_line_content_text <?php echo $donnees['isOnline'] ? 'online' : 'offline'; ?>">
                                                <p><strong>Hauteur</strong> : <?php echo $donnees['height']; ?> cm</p>
                                                <p><strong>Profondeur</strong> : <?php echo $donnees['depth']; ?> cm</p>
                                                <p><strong>Largeur</strong> : <?php echo $donnees['width']; ?> cm</p>
                                            </td>
                                            <td class="<?php echo $donnees['isOnline'] ? 'online' : 'offline'; ?>">
                                                <a class="button_modify" href="modifyLamp?id=<?php echo $donnees['lampId']; ?>"><i class="fas fa-edit"></i>Modifier</a>
                                                <!-- BUTTON SET SOLD / SET AVAILABLE -->
                                                <?php
                                                    if($donnees['isAvailable'])
                                                    {
                                                        ?>
                                                        <form id="setSold<?php echo $donnees['lampId']; ?>" action="setSold.php" method="post">
                                                            <input type="hidden" name="lampId" value="<?php echo $donnees['lampId']; ?>" />
                                                            <input type="hidden" name="updateIsAvailable" value="sold"/>
                                                        </form>
                                                        <a href="#" class="button_sell" onclick='document.getElementById("setSold<?php echo $donnees["lampId"]; ?>").submit()'><i class="fas fa-euro-sign"></i></i>Vendue</a>
                                                        
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <form id="setAvailable<?php echo $donnees['lampId']; ?>" action="setSold.php" method="post">
                                                            <input type="hidden" name="lampId" value="<?php echo $donnees['lampId']; ?>" />
                                                            <input type="hidden" name="updateIsAvailable" value="available"/>
                                                        </form>
                                                        <a href="#" class="button_sell" onclick='document.getElementById("setAvailable<?php echo $donnees["lampId"]; ?>").submit()'><i class="fab fa-creative-commons-nc-eu"></i>Non vendue</a>
                                                        
                                                        <?php
                                                    }
                                                ?>
                                                <!-- BUTTON SET ONLINE / SET OFFLINE -->
                                                <?php
                                                    if(!$donnees['isOnline'])
                                                    {
                                                        ?>
                                                        <form id="activeOnline<?php echo $donnees['lampId']; ?>" action="setOnline.php" method="post">
                                                            <input type="hidden" name="lampId" value="<?php echo $donnees['lampId']; ?>" />
                                                            <input type="hidden" name="activeOnline" value="online"/>
                                                        </form>
                                                        <a href="#" class="button_activeOnline" onclick='document.getElementById("activeOnline<?php echo $donnees["lampId"]; ?>").submit()'><i class="far fa-check-square"></i>Mettre en ligne</a>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <form id="activeOffline<?php echo $donnees['lampId']; ?>" action="setOnline.php" method="post">
                                                            <input type="hidden" name="lampId" value="<?php echo $donnees['lampId']; ?>" />
                                                            <input type="hidden" name="activeOnline" value="offline"/>
                                                        </form>
                                                            <a href="#" class="button_deactiveOnline" onclick='document.getElementById("activeOffline<?php echo $donnees["lampId"]; ?>").submit()'><i class="far fa-times-circle"></i>Mettre Hors-Ligne</a>
                                                        <?php
                                                    }
                                                ?>
                                                <!-- BUTTON SET IN NEWS / SET NOT IN NEWS -->
                                                <?php
                                                    if(!$donnees['isInNews'] AND $donnees['isOnline'])
                                                    {
                                                        ?>
                                                        <form id="activeInNews<?php echo $donnees['lampId']; ?>" action="setInNews.php" method="post">
                                                            <input type="hidden" name="lampId" value="<?php echo $donnees['lampId']; ?>" />
                                                            <input type="hidden" name="activeInNews" value="1"/>
                                                        </form>
                                                        <a href="#" class="button_activeInNews" onclick='document.getElementById("activeInNews<?php echo $donnees["lampId"]; ?>").submit()'><i class="far fa-check-square"></i>Devenir Star</a>
                                                        <?php
                                                    }
                                                ?>
                                                
                                            </td>
                                        </tr>

                                        <?php
                                    }
                                
                                ?>
                            </tbody>
                        </table>

                        <?php
                            $reponse->closeCursor();
                        ?>

                    </div>

                    <div class="separator"></div>

                </div>
                
            </div>

        </body>

    </html>

<?php 
    }
?>