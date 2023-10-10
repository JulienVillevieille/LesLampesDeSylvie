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

                <h2>Modifier Lampe</h2>

                <span class="button_returnAdmin">
                    <a href="administration"><i class="fas fa-backward"></i>Retour sur la page d'administration</a>
                </span>

                <form id="form_add_lamp" action="modifyLampForm.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">

                    <div id="input-select-form">

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
                            
                            $_GET['id'] = (int)$_GET['id'];
                            if(isset($_GET['id']) AND $_GET['id'] > 0)
                            {
                                $reponse = $bdd->prepare('SELECT * FROM lamps WHERE id = ?');
                                $reponse->execute(array($_GET['id']));
                                $donnees = $reponse->fetch();
                            }
                            else
                            {
                                header('Location: administration');
                            }
                        ?>

                        <span>  <!-- SPAN INPUT name -->
                            <label for="name-input">Nom :</label>
                            <input type="text" name="name" id="name-input" placeholder="Nom" value="<?php echo $donnees['lamp_name']; ?>" required>
                        </span>

                        <span> <!-- SPAN SELECT lampType-->
                            <?php // OUVERTURE DE LA BDD
                                try
                                {
                                    $bddLampTypes = new PDO('mysql:host=localhost;dbname=leslampesdesylvie;charset=utf8', 'root' , 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                                    // $bddLampTypes = new PDO('mysql:host=db5002459610.hosting-data.io;dbname=dbs1961658;charset=utf8', 'dbu1377283' , 'vegasylvie13!', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                                }
                                catch (Exception $e)
                                {
                                    die('Erreur : ' . $e->getMessage());
                                }

                                $reponseLampTypes = $bddLampTypes->query('SELECT id_lamps, lt.name AS lamp_type_name
                                                        FROM lamps_types AS lt
                                                        ORDER BY id_lamps
                                                        ');
                            ?>

                            <label for="type-select">Type :</label>
                            <select name="lampType" id="type-select" required>
                                <?php
                                    while($donneesLampTypes = $reponseLampTypes->fetch())
                                    {
                                        ?>

                                        <option value="<?php echo $donneesLampTypes['id_lamps']; ?>"
                                        <?php 
                                            if($donnees['lamp_type'] == $donneesLampTypes['id_lamps'])
                                            {
                                                echo "selected=\"selected\"";
                                            }
                                        ?>
                                        >
                                            <?php echo $donneesLampTypes['lamp_type_name']; ?> 
                                        </option>
                                        
                                        <?php
                                    }
                                    $reponseLampTypes->closeCursor();
                                ?>
                            </select>
                        </span>

                        <span>  <!-- SPAN INPUT category -->
                            <label for="category-input">Catégorie :</label>
                            <input type="text" name="category" id="category-input" placeholder="Catégorie" value="<?php echo $donnees['category']; ?>" required>
                        </span>

                        <span>  <!-- SPAN INPUT lamp_price -->
                            <label for="price-input">Prix (en €) :</label>
                            <input type="number" name="lamp_price" id="lampPrice-input" min="0" placeholder="0" value="<?php echo $donnees['price']; ?>" required>
                        </span>

                        <span> <!-- SPAN SELECT isPromo -->
                            <label for="isPromo_select">Lampe en promotion ?</label>
                            <select name="isPromo" id="isPromo_select" required>
                                <option value="0"
                                <?php 
                                    if($donnees['isPromo'] == 0)
                                    {
                                        echo "selected=\"selected\"";
                                    }
                                ?>
                                >Non</option>
                                <option value="1"
                                <?php 
                                    if($donnees['isPromo'] == 1)
                                    {
                                        echo "selected=\"selected\"";
                                    }
                                ?>
                                >Oui</option>
                            </select>
                        </span>

                        <span> <!-- SPAN input price_promo -->
                            <label for="pricePromo_input">Prix en promotion (en €) <em>[Modifier que si la lampe est en promotion - voir haut dessus]</em></label>
                            <input type="number" name="price_promo" id="pricePromo_input" min="0" value="<?php echo $donnees['pricePromo']; ?>" required />
                        </span>

                        <span>  <!-- SPAN SELECT isOnline -->
                            <label for="online-select">Lampe en ligne ?</label>
                            <select name="isOnline" id="online-select" required> 
                                <option value="0"
                                <?php 
                                    if($donnees['isOnline'] == 0)
                                    {
                                        echo "selected=\"selected\"";
                                    }
                                ?>
                                >Hors Ligne</option>
                                <option value="1"
                                <?php 
                                    if($donnees['isOnline'] == 1)
                                    {
                                        echo "selected=\"selected\"";
                                    }
                                ?>
                                >En ligne</option>
                            </select>
                        </span>

                        <span> <!-- SPAN SELECT isAvailable-->
                            <label for="buy-select">Lampe vendue ?</label>
                            <select name="isAvailable" id="available-select" required>
                                <option value="1"
                                <?php 
                                    if($donnees['isAvailable'] == 1)
                                    {
                                        echo "selected=\"selected\"";
                                    }
                                ?>
                                >Non vendue</option>
                                <option value="0"
                                <?php 
                                    if($donnees['isAvailable'] == 0)
                                    {
                                        echo "selected=\"selected\"";
                                    }
                                ?>
                                >Vendue</option>
                            </select>
                        </span>

                        <span> <!-- SPAN TEXTAREA presentationText-->
                            <label for="presentationText-input">Texte de présentation :</label>
                            <textarea name="presentationText" id="presentationText-input" placeholder="Texte de présentation..." rows="10" required><?php echo $donnees['presentation_text']; ?></textarea>
                        </span>

                        <span> <!-- SPAN TEXTAREA technicalText -->
                            <label for="technicalText-input">Texte technique :</label>
                            <textarea name="technicalText" id="technicalText-input" placeholder="Texte technique..." rows="10" required><?php echo $donnees['technical_text']; ?></textarea>
                        </span>

                        <span>  <!-- SPAN INPUT lamp_height -->
                            <label for="height-input">Hauteur (en cm) :</label>
                            <input type="number" name="lamp_height" id="height-input" min="0" placeholder="0" value="<?php echo $donnees['height']; ?>" required />
                        </span>

                        <span>  <!-- SPAN INPUT lamp_depth -->
                            <label for="depth-input">Profondeur (en cm) :</label>
                            <input type="number" name="lamp_depth" id="depth-input" min="0" placeholder="0" value="<?php echo $donnees['depth']; ?>" required />
                        </span>

                        <span>  <!-- SPAN INPUT lamp_width -->
                            <label for="width-input">Largeur (en cm) :</label>
                            <input type="number" name="lamp_width" id="width-input" min="0" placeholder="0" value="<?php echo $donnees['width']; ?>" required />
                        </span>

                        <span> <!-- SPAN INPUT urlImgCover -->
                            <label for="url_img_cover">Image de couverture</label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="104857600" /> <!-- Limite 100Mo -->
                            <input type="file" name="urlImgCover" accept=".jpg, .jpeg" />
                            <img src="<?php echo $donnees['url_img_cover']; ?>" />
                        </span>

                        <span> <!-- SPAN INPUT urlImg1 / urlImg2 / urlImg3 / urlImg4 -->
                            <label for="url_img_1">Image de présentation 1</label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="104857600" /> <!-- Limite 100Mo -->
                            <input type="file" name="urlImg1" accept=".jpg, .jpeg" />
                            <img src="<?php echo $donnees['url_img_1']; ?>" />

                            <label for="url_img_2">Image de présentation 2</label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="104857600" /> <!-- Limite 100Mo -->
                            <input type="file" name="urlImg2" accept=".jpg, .jpeg" />
                            <img src="<?php echo $donnees['url_img_2']; ?>" />

                            <label for="url_img_3">Image de présentation 3</label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="104857600" /> <!-- Limite 100Mo -->
                            <input type="file" name="urlImg3" accept=".jpg, .jpeg" />
                            <img src="<?php echo $donnees['url_img_3']; ?>" />

                            <label for="url_img_4">Image de présentation 4</label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="104857600" /> <!-- Limite 100Mo -->
                            <input type="file" name="urlImg4" accept=".jpg, .jpeg" />
                            <img src="<?php echo $donnees['url_img_4']; ?>" />
                        </span>

                        <span> <!-- SPAN INPUT urlLampOn / urlLampOff -->
                            <label for="url_img_lamp_on">Image lampe allumée</label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="104857600" /> <!-- Limite 100Mo -->
                            <input type="file" name="urlLampOn" accept=".jpg, .jpeg" />
                            <img src="<?php echo $donnees['url_img_lamp_on']; ?>" />

                            <label for="url_img_lamp_off">Image lampe éteinte</label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="104857600" /> <!-- Limite 100Mo -->
                            <input type="file" name="urlLampOff" accept=".jpg, .jpeg" />
                            <img src="<?php echo $donnees['url_img_lamp_off']; ?>" />
                        </span>
                        
                        <span>
                            <button type="submit" value="search">Confirmer la modification</button>
                        </span>

                        <?php
                            $reponse->closeCursor();
                        ?>
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