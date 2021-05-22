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
        }
        else{
            $poruka="You have to choose image";
            $greske++;
        }
        


    
        $naslov= $_POST['naslov'];
        $tekst= $_POST['tekst'];
        $kat= $_POST['kategorija'];
        $datum=date("Y-m-d H:i:s");

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
        if(!isset($_FILES['slika'])){
            $poruka="You have to choose image";
            $greske++;
        }

        if($greske==0){
            
        $rezultat=move_uploaded_file($tmpName,$putanja);
        if(!$rezultat){
            $poruka="Error";
            $kod=200;
        }
        else{
            $upit="INSERT INTO postovi VALUES (null, :naslov, :tekst, :datum, :idKat, :slika)";
            $priprema=$konekcija->prepare($upit);
            $priprema->bindParam(":naslov",$naslov);
            $priprema->bindParam(":tekst",$tekst);
            $priprema->bindParam(":datum",$datum);
            $priprema->bindParam(":idKat",$kat);
            $priprema->bindParam(":slika",$naziv);
            try{
                $priprema->execute();
                $poruka="Post successfully added";
                $kod=201;
            }
            catch(PDOException $e){
                $poruka="Server error";
                $kod=500;
            }
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