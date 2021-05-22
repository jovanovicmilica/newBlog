<?php

    require_once "konekcija.php";   

    if(isset($_GET['code'])){
        $kod=$_GET['code'];
    
    $upit="SELECT * FROM korisnici WHERE aktivacionikod=:kod";

    $priprema=$konekcija->prepare($upit);
    $priprema->bindParam(":kod",$kod);
    try{
        $priprema->execute();
        if($priprema->rowCount()==1){
            $korisnik=$priprema->fetch();
            $ime=$korisnik['ime'];
            $aktivan=1;
            $upit2="UPDATE korisnici SET aktivan=:akt WHERE aktivacioniKod=:kod";
            $priprema2=$konekcija->prepare($upit2);
            $priprema2->bindParam(":akt",$aktivan);
            $priprema2->bindParam(":kod",$kod);
            try{
                $priprema2->execute();
                $data="$ime, You have successfully activated your account";
            }
            catch(PDOException $e){
                $data="Server error";;
            }
        }
        else{
            $data="Invalid code";
        }
    }
    catch(PDOException $e){
        $data="Server error";
    }
    }
    else{
        $data="Invalid access";
    }
    

?>