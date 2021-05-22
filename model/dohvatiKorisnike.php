<?php

    require_once "konekcija.php";

    $data="";
    $upit="SELECT * FROM korisnici";

    
    try{  
        $kategorije=$konekcija->query($upit)->fetchAll();
        $data=$kategorije;
        $code=200;
    }
    catch(PDOException $e){
        $code=500;
        $data="Server error";
    }

    
echo json_encode($data);
http_response_code($code);
?>