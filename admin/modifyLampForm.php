<?php
    session_start();

    $WIDTH_MAX_IMG = 800;
    $HEIGHT_MAX_IMG = 1000;

    if(
        isset($_POST['name']) AND 
        isset($_POST['lampType']) AND
        isset($_POST['category']) AND
        isset($_POST['lamp_price']) AND
        isset($_POST['isPromo']) AND
        isset($_POST['price_promo']) AND
        isset($_POST['isOnline']) AND
        isset($_POST['isAvailable']) AND
        isset($_POST['presentationText']) AND
        isset($_POST['technicalText']) AND
        isset($_POST['lamp_height']) AND
        isset($_POST['lamp_depth']) AND
        isset($_POST['lamp_width']) AND
        isset($_FILES['urlImgCover']) AND
        isset($_FILES['urlImg1']) AND
        isset($_FILES['urlImg2']) AND
        isset($_FILES['urlImg3']) AND
        isset($_FILES['urlImg4']) AND
        isset($_FILES['urlLampOn']) AND
        isset($_FILES['urlLampOff'])
    )
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

        $req = $bdd->prepare('UPDATE lamps SET isOnline = :isOnline, lamp_name = :lampName, lamp_type = :lampType, category = :category, presentation_text = :presentationText, 
                            technical_text = :technicalText, height = :height, width = :width, depth = :depth, price = :price, isPromo = :isPromo, pricePromo = :pricePromo, isAvailable = :isAvailable, 
                            url_img_cover = :urlCover, url_img_1 = :url1, url_img_2 = :url2, url_img_3 = :url3, url_img_4 = :url4, url_img_lamp_off = :urlLampOff, url_img_lamp_on = :urlLampOn
                            WHERE id='.$_GET['id'].'
                            ');

        $_POST['isOnline'] = (int) $_POST['isOnline'];
        $isOnline = (($_POST['isOnline'] == 0 OR $_POST['isOnline'] == 1) ? $_POST['isOnline'] : 0);

        $lampName = strip_tags($_POST['name']);
        
        $_POST['lampType'] = (int) $_POST['lampType'];
        $lampType = (($_POST['lampType'] >= 1 AND $_POST['lampType'] <= 4) ? $_POST['lampType'] : 3);

        $category = strip_tags($_POST['category']);

        $presentationText = $_POST['presentationText'];

        $technicalText = $_POST['technicalText'];

        $_POST['lamp_height'] = (int) $_POST['lamp_height'];
        $height = (($_POST['lamp_height'] > 0 AND $_POST['lamp_height'] < 1000) ? $_POST['lamp_height'] : 0);

        $_POST['lamp_width'] = (int) $_POST['lamp_width'];
        $width = (($_POST['lamp_width'] > 0 AND $_POST['lamp_width'] < 1000) ? $_POST['lamp_width'] : 0);

        $_POST['lamp_depth'] = (int) $_POST['lamp_depth'];
        $depth = (($_POST['lamp_depth'] > 0 AND $_POST['lamp_depth'] < 1000) ? $_POST['lamp_depth'] : 0);

        $_POST['lamp_price'] = (int) $_POST['lamp_price'];
        $price = (($_POST['lamp_price'] >= 0 AND $_POST['lamp_price'] < 5000) ? $_POST['lamp_price'] : 0);

        $_POST['isPromo'] = (int) $_POST['isPromo'];
        $isPromo = (($_POST['isPromo'] == 0 OR $_POST['isPromo'] == 1) ? $_POST['isPromo'] : 0);

        $_POST['price_promo'] = (int) $_POST['price_promo'];
        $pricePromo = (($_POST['price_promo'] >= 0 AND $_POST['price_promo'] < 5000) ? $_POST['price_promo'] : 0);

        $_POST['isAvailable'] = (int) $_POST['isAvailable'];
        $isAvailable = (($_POST['isAvailable'] == 0 OR $_POST['isAvailable'] == 1) ? $_POST['isAvailable'] : 0);

        // $path = '../images/' . $_POST['name'] . '_img/';
        $path = '../images/' . 'lampID' . $_GET['id'] . '_img/';
            if(!file_exists($path))
            {
                mkdir($path, 0777, true);
            }
        
        
        $filenameCover = 'lampID' . $_GET['id'] . '_cover.jpg';
        $filename1 = 'lampID' . $_GET['id'] . '_1.jpg';
        $filename2 = 'lampID' . $_GET['id'] . '_2.jpg';
        $filename3 = 'lampID' . $_GET['id'] . '_3.jpg';
        $filename4 = 'lampID' . $_GET['id'] . '_4.jpg';
        $filenameOn = 'lampID' . $_GET['id'] . '_on.jpg';
        $filenameOff = 'lampID' . $_GET['id'] . '_off.jpg';


        if($_FILES['urlImgCover']['name'] != "")
        {
            $source = imagecreatefromjpeg($_FILES['urlImgCover']['tmp_name']);
            $imgCover = automaticResize($source, $WIDTH_MAX_IMG, $HEIGHT_MAX_IMG);
            imagejpeg($imgCover, $path . $filenameCover);
            // move_uploaded_file($_FILES['urlImgCover']['tmp_name'], $path . $filenameCover);
        }
        if($_FILES['urlImg1']['name'] != "")
        {
            $source = imagecreatefromjpeg($_FILES['urlImg1']['tmp_name']);
            $img1 = automaticResize($source, $WIDTH_MAX_IMG, $HEIGHT_MAX_IMG);
            imagejpeg($img1, $path . $filename1);
            // move_uploaded_file($_FILES['urlImg1']['tmp_name'], $path . $filename1);
        }
        if($_FILES['urlImg2']['name'] != "")
        {
            $source = imagecreatefromjpeg($_FILES['urlImg2']['tmp_name']);
            $img2 = automaticResize($source, $WIDTH_MAX_IMG, $HEIGHT_MAX_IMG);
            imagejpeg($img2, $path . $filename2);
            // move_uploaded_file($_FILES['urlImg2']['tmp_name'], $path . $filename2);
        }
        if($_FILES['urlImg3']['name'] != "")
        {
            $source = imagecreatefromjpeg($_FILES['urlImg3']['tmp_name']);
            $img3 = automaticResize($source, $WIDTH_MAX_IMG, $HEIGHT_MAX_IMG);
            imagejpeg($img3, $path . $filename3);
            // move_uploaded_file($_FILES['urlImg3']['tmp_name'], $path . $filename3);
        }
        if($_FILES['urlImg4']['name'] != "")
        {
            $source = imagecreatefromjpeg($_FILES['urlImg4']['tmp_name']);
            $img4 = automaticResize($source, $WIDTH_MAX_IMG, $HEIGHT_MAX_IMG);
            imagejpeg($img4, $path . $filename4);
            // move_uploaded_file($_FILES['urlImg4']['tmp_name'], $path . $filename4);
        }
        if($_FILES['urlLampOn']['name'] != "")
        {
            $source = imagecreatefromjpeg($_FILES['urlLampOn']['tmp_name']);
            $imgLampOn = automaticResize($source, $WIDTH_MAX_IMG, $HEIGHT_MAX_IMG);
            imagejpeg($imgLampOn, $path . $filenameOn);
            // move_uploaded_file($_FILES['urlLampOn']['tmp_name'], $path . $filenameOn);
        }
        if($_FILES['urlLampOff']['name'] != "")
        {
            $source = imagecreatefromjpeg($_FILES['urlLampOff']['tmp_name']);
            $imgLampOff = automaticResize($source, $WIDTH_MAX_IMG, $HEIGHT_MAX_IMG);
            imagejpeg($imgLampOff, $path . $filenameOff);
            // move_uploaded_file($_FILES['urlLampOff']['tmp_name'], $path . $filenameOff);
        }

        $req->execute(array(
                'isOnline' => $isOnline,
                'lampName' => $lampName,
                'lampType' => $lampType,
                'category' => $category,
                'presentationText' => $presentationText,
                'technicalText' => $technicalText,
                'height' => $height,
                'width' => $width,
                'depth' => $depth,
                'price' => $price,
                'isPromo' => $isPromo,
                'pricePromo' => $pricePromo,
                'isAvailable' => $isAvailable,
                'urlCover' => $path . $filenameCover,
                'url1' => $path . $filename1,
                'url2' => $path . $filename2,
                'url3' => $path . $filename3,
                'url4' => $path . $filename4,
                'urlLampOn' => $path . $filenameOn,
                'urlLampOff' => $path . $filenameOff
        ));
        
        $_SESSION['message'] = "La lampe \"" . $_POST['name'] . "\" a bien été modifiée !";
        $_SESSION['lampCreated'] = true;

        header('Location: administration');
    }
    else
    {
        $_SESSION['message'] = "Erreur à la modification de la lampe !";
        $_SESSION['lampCreated'] = false;
        header('Location: administration');
    }





    function automaticResize($imgToResize, $maxWidth, $maxHeight)
    {
        $dimension = modifyImage($imgToResize, $maxWidth, $maxHeight);

        // Redimensionner
        $destination = imagecreatetruecolor($dimension[0], $dimension[1]) or die('Impossible de creer l\'image de destination');
        $color = imagecolorallocate($destination, 0, 0, 0);
        imagecolortransparent($destination, $color); // On rend le fond transparent
    
        // Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
        $largeur_source = imagesx($imgToResize);
        $hauteur_source = imagesy($imgToResize);
        $largeur_destination = imagesx($destination);
        $hauteur_destination = imagesy($destination);
        
        // On crée la miniature
        imagecopyresampled($destination, $imgToResize, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);

        return $destination;
    }

    function modifyImage($imgToModify, $largeur, $hauteur) 
    {
        $dst_w = $largeur;
        $dst_h = $hauteur;
         
        // Lit les dimensions de l'image
        //$size = getimagesize($img); 
        $src_w = imagesx($imgToModify);
        $src_h = imagesy($imgToModify);
        
        // Teste les dimensions tenant dans la zone
        $test_h = round(($dst_w / $src_w) * $src_h);
        $test_w = round(($dst_h / $src_h) * $src_w);
        
        // Si Height final non précisé (0)
        if(!$dst_h) $dst_h = $test_h;
            
        // Sinon si Width final non précisé (0)
        elseif(!$dst_w) $dst_w = $test_w;
            
        // Sinon teste quel redimensionnement tient dans la zone
        elseif($test_h>$dst_h) $dst_w = $test_w;
        else $dst_h = $test_h;
            
        if($dst_h > 1 AND $dst_h < $hauteur){
            $paddingTop = ceil(($hauteur - $dst_h) / 2);
        }
        else{
            $paddingTop = 0;
        }
        $pad = " style=\"margin-top:".$paddingTop."px;\"";
        
        $tab = array($dst_w, $dst_h, $pad);
        return $tab;
    }
?>