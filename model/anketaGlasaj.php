<?php
session_start();
    require_once "konekcija.php";
    $kod=200;
    $poruka="";
    $user=$_SESSION['user'];
    $idUser=$user['idKorisnika'];

    $idOdgovor=$_POST['odgovor'];

    $upit="INSERT INTO odgovorianketa VALUES(null,:odg,:kor)";
    $priprema=$konekcija->prepare($upit);
    $priprema->bindParam(":odg",$idOdgovor);
    $priprema->bindParam(":kor",$idUser);
    try{
        $priprema->execute();
    }
    catch(PDOException $e){
        $poruka="Server error";
        $kod=500;
    }



echo json_encode($poruka);
http_response_code($kod);
?>