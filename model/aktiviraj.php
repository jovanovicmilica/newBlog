<?php

    require_once "konekcija.php";

        $code=200;
        $data="";


        $upit="UPDATE anketa SET aktivna=1";
        
        try{  
            $konekcija->query($upit);
        }
        catch(PDOException $e){
            $code=500;
            $data="Server error";
        }

    
echo json_encode($data);
http_response_code($code);
?>
