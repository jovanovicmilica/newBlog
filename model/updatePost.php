<?php

    require_once "konekcija.php";


    
    if(isset($_POST['dugme'])){
        $poruka="";
        $kod=200;
        $greske=0;
        if(isset($_FILES['slika'])){
            $slika=$_FILES['slika'];

            $tmpName=$slika['tmp_name'];
            $size=$slika['size'];
            $tip=$slika['type'];
            $name=$slika['name'];
            $naziv=time().$name;
            $putanja="../assets/images/$naziv";
            
            $rezultat=move_uploaded_file($tmpName,$putanja);
        }
        


    
        $naslov= $_POST['naslov'];
        $tekst= $_POST['tekst'];
        $kat= $_POST['kategorija'];
        $idPosta= $_POST['idPosta'];

        $greske=0;

        $regNaslov="/^[A-Z][a-z]+(\s[A-z]*\d*)+$/";
        $regTekst=explode(" ",$tekst);

        if(!preg_match($regNaslov,$naslov)){
            $poruka="Title must begin with capital letter and have 2 words minimum";
            $greske++;
        }
        if(count($regTekst)<50){
            $poruka="Text must begin with capital letter and have 50 words minimum";
            $greske++;
        }
        if($kat=="null"){
            $poruka="You have to choose category";
            $greske++;
        }

        if($greske==0){
            
        if(isset($_FILES['slika'])){
            $upit="UPDATE postovi SET naslov=:naslov,tekst=:tekst,idKategorije=:idKat,slikasrc=:slika";
        }
        else{
            $upit="UPDATE postovi SET naslov=:naslov,tekst=:tekst,idKategorije=:idKat";
        }
        $upit.=" WHERE idPosta=:id";
            $priprema=$konekcija->prepare($upit);
            $priprema->bindParam(":naslov",$naslov);
            $priprema->bindParam(":tekst",$tekst);
            $priprema->bindParam(":idKat",$kat);
            $priprema->bindParam(":id",$idPosta);
            if(isset($_FILES['slika'])){
                $priprema->bindParam(":slika",$naziv);
            }
            try{
                $priprema->execute();
                $poruka="Post successfully updated";
                $kod=201;
            }
            catch(PDOException $e){
                $poruka=$e->getMessage();
                $kod=500;
            }
        }


    }
    else{
        $kod=404;
        $poruka="Error.";
    }


    
echo json_encode($poruka);
http_response_code($kod);
?>