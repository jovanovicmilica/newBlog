<?php

    require_once "konekcija.php";

    $upit="SELECT * FROM anketa WHERE aktivna=1";
    try{
        $rezultat=$konekcija->query($upit);
        if($rezultat->rowCount()==1){
            $pitanje=$rezultat->fetch();
            $idPitanje=$pitanje['idAnkete'];
            if(isset($_SESSION['user'])){
            $user=$_SESSION['user'];
            $idUser=$user['idKorisnika'];
            $daLiJeGlasao="SELECT * FROM odgovorianketa oa INNER JOIN odgovori o ON oa.idOdgovora=o.idOdgovora WHERE oa.idKorisnika=$idUser AND o.idAnkete=$idPitanje";
            try{
                $glasao=$konekcija->query($daLiJeGlasao);
                if($glasao->rowCount()==0){
                    $upit2="SELECT * FROM odgovori WHERE idAnkete=:id";
                    $priprema=$konekcija->prepare($upit2);
                    $priprema->bindParam(":id",$idPitanje);
                    try{
                        $priprema->execute();
                        $odgovori=$priprema->fetchAll();
                    }
                    catch(PDOException $e){
                        $greskaAnketa="Server error";
                    }
                }
                else{
                    $greskaAnketa="";
                }
            }
            catch(PDOException $e){
                $greskaAnketa=$e;
            }
            }
            
        }
        else{
            $greskaAnketa="";
        }
    }
    catch(PDOException $e){
        $greskaAnketa="Server error";
    }

?>