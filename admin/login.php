<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/login.css">
        <link rel="stylesheet" href="../css/fonts.css">
        <link rel="icon" href="../images/favicon.ico">

        <!-- ICONS -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

        <title>Les Lampes de Sylvie - Administration - Identification</title>

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

            <div id="main_body_home">

                <h2>Identification</h2>

                <?php
                    if(isset($_SESSION['wrongUserID']) && $_SESSION['wrongUserID'])
                    {
                        ?>
                        <p class="badUserID"><i class="fas fa-exclamation-triangle"></i>Erreur d'identification, votre identifiant ou votre mot de passe est incorrect.</p>
                        <?php
                    }
                    
                    $_SESSION['wrongUserID'] = false;
                ?>

                <form id="login_form" action="administration.php" method="post">

                    <div class="mb-3">
                        <label for="userID" class="form-label">Identifiant : </label>
                        <input type="text" class="form-control" id="userID" name="userID" placeholder="Identifiant">
                    </div>

                    <div class="mb-3">
                        <label for="userPassword" class="form-label">Mot de passe : </label>
                        <input type="password" class="form-control" id="userPassword" name="userPassword">
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Se Connecter</button>
                    </div>

                    <div class="mb-3">
                        <p class="access_site">Accéder au site : <a href="../index.php">leslampesdesylvie.fr</a></p>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>




