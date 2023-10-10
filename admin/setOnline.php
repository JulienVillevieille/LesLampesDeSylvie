<?php
    if(isset($_POST['activeOnline']) AND isset($_POST['lampId']))
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

        $req = $bdd->prepare('UPDATE lamps SET isOnline = :isOnline WHERE id = :lampId');

        switch ($_POST['activeOnline'])
        {
            case "online":
                $req->execute(array(
                        'isOnline' => 1,
                        'lampId' => $_POST['lampId']
                    ));
                header('Location: administration');
                break;

            case "offline":
                $req->execute(array(
                    'isOnline' => 0,
                    'lampId' => $_POST['lampId']
                ));
                header('Location: administration');
                break;

            default: 
                header('Location: administration');
                break;
        }
    }
    else
    {
        header('Location: administration');
    }
?>