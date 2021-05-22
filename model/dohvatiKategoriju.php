<?php

    require_once "konekcija.php";

    $code=200;
    $data="";
    $id=$_POST['id'];
    $upit="SELECT * FROM kategorije WHERE idKategorije=$id";

    
    try{  
        $kategorije=$konekcija->query($upit)->fetch();
        $code=200;
    }
    catch(PDOException $e){
        $kategorije="Server error";
        $code=500;
    }

http_response_code($code);
echo json_encode($kategorije);
?>