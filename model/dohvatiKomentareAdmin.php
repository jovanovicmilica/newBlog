<?php

    require_once "konekcija.php";

    $data="";
    $upit="SELECT k.*,ko.email,p.naslov FROM komentari k INNER JOIN korisnici ko ON ko.idKorisnika=k.idKorisnika INNER JOIN postovi p on k.idPosta=p.idPosta ORDER BY k.datumKomentara";

    
    try{  
        $kategorije=$konekcija->query($upit)->fetchAll();
        $data=$kategorije;
        $code=200;
    }
    catch(PDOException $e){
        $code=500;
        $data=$e;
    }

    
echo json_encode($data);
http_response_code($code);
?>