<?php
    if(isset($_POST['activeInNews']) AND isset($_POST['lampId']))
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

        if($_POST['activeInNews'] == 1)
        {
            $req = $bdd->exec('UPDATE lamps SET isInNews=0 WHERE isInNews=1');

            $req = $bdd->prepare('UPDATE lamps SET isInNews = :isInNews WHERE id = :lampId');

            $req->execute(array(
                'isInNews' => $_POST['activeInNews'],
                'lampId' => $_POST['lampId']
            ));
            header('Location: administration');
        }
        else
        {
            header('Location: administration');
        }
    }
    else
    {
        header('Location: administration');
    }
?>