<?php

    require_once "konekcija.php";

    $data="";
    $upit="SELECT * FROM sponzori ORDER BY idSponzor";

    
    try{  
        $sponzori=$konekcija->query($upit)->fetchAll();
        $code=200;
    }
    catch(PDOException $e){
        $sponzori="Server error";
        $code=500;
    }

http_response_code($code);
echo json_encode($sponzori);
?>