<?php
session_start();
    require_once "konekcija.php";

    $data="";
    if(isset($_POST['send'])){
        if(isset($_SESSION['korisnik'])){
            $idAnkete=$_POST['anketa'];
            $odgovor=$_POST['izbor'];
            $korisnik=$_SESSION['korisnik'];
            $idKorisnik=$korisnik['idKorisnika'];

            $upit="INSERT INTO odgovorianketa VALUES (NULL,:odg,:idAnketa,:idKorisnik)";
            $priprema=$konekcija->prepare($upit);
            $priprema->bindParam(":odg",$odgovor);
            $priprema->bindParam(":idAnketa",$idAnkete);
            $priprema->bindParam(":idKorisnik",$idKorisnik);
            try{
                $priprema->execute();
                $code=201;
                $data="Thank you for voting";
            }
            catch(PDOException $e){
                $code=500;
                $data="Server error";
            }
        }
        else{
            $code=200;
            $data="You have to log in to vote";
        }
    }
    else{
        $code=404;
    }

    
echo json_encode($data);
http_response_code($code);

?>