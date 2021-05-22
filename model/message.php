<?php

    require_once "konekcija.php";

if(isset($_POST["btnMessage"])){
    $kod=200;
    $mail=$_POST["mail"];
    $naslov=$_POST["naslov"];
    $poruka=$_POST["poruka"];
    $regEmail="/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/";
    $regNaslov="/^[\w\s]+$/";
    $greska=0;
    if(!preg_match($regEmail,$mail)){
        $greska++;
        $data="E-mail format: pera.peric.55.19@ict.edu.rs or pera@gmail.com";
    }
    if(!preg_match($regNaslov,$naslov)){
        $greska++;
        $data="You have to write title";
    }
    if(count($poruka)<10){
        $greska++;
        $data="Message mus have 10 words minimum";
    }
    if($greska==0){
        $poruka=implode($poruka," ");
        $datum=date("Y-m-d H:i:s");
        $insert="INSERT INTO poruke VALUES(null,:naslov,:poruka,:mail,:datum)";
        $priprema=$konekcija->prepare($insert);
        $priprema->bindParam(":mail",$mail);
        $priprema->bindParam(":naslov",$naslov);
        $priprema->bindParam(":poruka",$poruka);
        $priprema->bindParam(":datum",$datum);
        try{
            $priprema->execute();
            $poruka="Message successfuly sent";
            $kod=201;
        }
        catch(PDOException $e){
            $poruka="Server error";
            $kod=500;
            zabeleziGresku($e);
        }
    }
}
else{
    $kod=404;
    $poruka="Error";
}

echo json_encode($poruka);
http_response_code($kod);
?>