<?php
    session_start();
?>

<?php
    
    if(isset($_SESSION['isConnected']) && $_SESSION['isConnected'])
    {
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/addNewLamp.css">
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/fonts.css">
        <link rel="icon" href="../images/favicon.ico">

        <!-- ICONS -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

        <title>Les Lampes de Sylvie - Ajout Lampe</title>

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

                <h2>Nouvelle Lampe</h2>

                <span class="button_returnAdmin">
                    <a href="administration.php"><i class="fas fa-backward"></i>Retour sur la page d'administration</a>
                </span>

                <form id="form_add_lamp" action="addNewLampForm.php" method="post" enctype="multipart/form-data">

                    <div id="input-select-form">

                        <span>  <!-- SPAN INPUT name -->
                            <label for="name-input">Nom :</label>
                            <input type="text" name="name" id="name-input" placeholder="Nom" value="" required>
                        </span>

                        <span> <!-- SPAN SELECT lampType-->
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

                            <label for="type-select">Type :</label>
                            <select name="lampType" id="type-select" required>
                                <?php
                                    while($donnees = $reponse->fetch())
                                    {
                                        ?>

                                        <option value="<?php echo $donnees['id_lamps']; ?>">
                                            <?php echo $donnees['lamp_type_name']; ?> 
                                        </option>
                                        
                                        <?php
                                    }
                                    $reponse->closeCursor();
                                ?>
                            </select>
                        </span>

                        <span>  <!-- SPAN INPUT category -->
                            <label for="category-input">Catégorie :</label>
                            <input type="text" name="category" id="category-input" placeholder="Catégorie" value="" required>
                        </span>

                        <span>  <!-- SPAN INPUT lamp_price -->
                            <label for="price-input">Prix (en €) :</label>
                            <input type="number" name="lamp_price" id="lampPrice-input" min="0" placeholder="0" required />
                        </span>

                        <span> <!-- SPAN SELECT isPromo -->
                            <label for="isPromo_select">Lampe en promotion ?</label>
                            <select name="isPromo" id="isPromo_select" required>
                                <option value="0">Non</option>
                                <option value="1">Oui</option>
                            </select>
                        </span>

                        <span> <!-- SPAN input price_promo -->
                            <label for="pricePromo_input">Prix en promotion (en €) <em>[Modifier que si la lampe est en promotion - voir haut dessus]</em></label>
                            <input type="number" name="price_promo" id="pricePromo_input" min="0" value="0" required />
                        </span>

                        <span>  <!-- SPAN SELECT isOnline -->
                            <label for="online-select">Lampe en ligne ?</label>
                            <select name="isOnline" id="online-select" required> 
                                <option value="0">Hors Ligne</option>
                                <option value="1">En ligne</option>
                            </select>
                        </span>

                        <span> <!-- SPAN SELECT isAvailable-->
                            <label for="buy-select">Lampe vendue ?</label>
                            <select name="isAvailable" id="available-select" required>
                                <option value="1">Non vendue</option>
                                <option value="0">Vendue</option>
                            </select>
                        </span>

                        <span> <!-- SPAN TEXTAREA presentationText-->
                            <label for="presentationText-input">Texte de présentation :</label>
                            <textarea name="presentationText" id="presentationText-input" placeholder="Texte de présentation..." value="" rows="10" required></textarea>
                        </span>

                        <span> <!-- SPAN TEXTAREA technicalText -->
                            <label for="technicalText-input">Texte technique :</label>
                            <textarea name="technicalText" id="technicalText-input" placeholder="Texte technique..." value="" rows="10" required></textarea>
                        </span>

                        <span>  <!-- SPAN INPUT lamp_height -->
                            <label for="height-input">Hauteur (en cm) :</label>
                            <input type="number" name="lamp_height" id="height-input" min="0" placeholder="0" required />
                        </span>

                        <span>  <!-- SPAN INPUT lamp_depth -->
                            <label for="depth-input">Profondeur (en cm) :</label>
                            <input type="number" name="lamp_depth" id="depth-input" min="0" placeholder="0" required />
                        </span>

                        <span>  <!-- SPAN INPUT lamp_width -->
                            <label for="width-input">Largeur (en cm) :</label>
                            <input type="number" name="lamp_width" id="width-input" min="0" placeholder="0" required />
                        </span>

                        <span> <!-- SPAN INPUT urlImgCover -->
                            <label for="url_img_cover">Image de couverture</label>
                            <input type="file" name="urlImgCover" accept=".jpg, .jpeg" required />
                        </span>

                        <span> <!-- SPAN INPUT urlImg1 / urlImg2 / urlImg3 / urlImg4 -->
                            <label for="url_img_1">Image de présentation 1</label>
                            <input type="file" name="urlImg1" accept=".jpg, .jpeg" required />

                            <label for="url_img_2">Image de présentation 2</label>
                            <input type="file" name="urlImg2" accept=".jpg, .jpeg" required />

                            <label for="url_img_3">Image de présentation 3</label>
                            <input type="file" name="urlImg3" accept=".jpg, .jpeg" required />

                            <label for="url_img_4">Image de présentation 4</label>
                            <input type="file" name="urlImg4" accept=".jpg, .jpeg" required />
                        </span>

                        <span> <!-- SPAN INPUT urlLampOn / urlLampOff -->
                            <label for="url_img_lamp_on">Image lampe allumée</label>
                            <input type="file" name="urlLampOn" accept=".jpg, .jpeg" required />

                            <label for="url_img_lamp_off">Image lampe éteinte</label>
                            <input type="file" name="urlLampOff" accept=".jpg, .jpeg" required />
                        </span>
                        
                        <span>
                            <button type="submit" value="search">Valider</button>
                        </span>
                    </div>
                </form>

            </div>

            <div class="separator"></div>

        </div>
    </body>
</html>

<?php 
    }
    else
    {
        header('Location: login.php');
    }
?>