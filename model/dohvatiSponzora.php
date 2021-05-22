<?php
    require_once "konekcija.php";
    $data="";
    $kod=200;

    $id=$_POST['id'];
    $upit="SELECT * FROM sponzori WHERE idSponzor=$id";

    try{
        $rez=$konekcija->query($upit);
        $data=$rez->fetch();
    }
    catch(PDOException $e){
        $data="Server error";
        $kod=500;
    }

echo json_encode($data);
http_response_code($kod);
?>