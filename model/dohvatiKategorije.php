<?php

    require_once "konekcija.php";

    $data="";
    $upit="SELECT * FROM kategorije";

    
    try{  
        $kategorije=$konekcija->query($upit)->fetchAll();
        $code=200;
    }
    catch(PDOException $e){
        $kategorije="Server error";
        $code=500;
    }

?>