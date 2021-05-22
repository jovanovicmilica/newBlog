<?php
session_start();
    require_once "konekcija.php";

    $data="";
    $code=200;

    if(isset($_SESSION['user'])){
        $user=$_SESSION['user'];
        $idUser=$user['idKorisnika'];
        $idPosta=$_POST['id'];
        $upit="DELETE FROM lajkovi WHERE idPosta=:idPost AND idKorisnika=:idKorisnik";
        $priprema=$konekcija->prepare($upit);
        $priprema->bindParam(":idPost",$idPosta);
        $priprema->bindParam(":idKorisnik",$idUser);
        try{
            $priprema->execute();
        }
        catch(PDOException $e){
            $code=500;
            $data="Server error";
        }
    }
    else{
        $code=400;
        $data="Error";
    }

    
http_response_code($code);
echo json_encode($data);
?>