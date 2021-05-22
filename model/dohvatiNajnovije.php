<?php

    require_once "konekcija.php";

    $data="";
    $upit="SELECT *,LEFT(tekst,250) AS tekst,(SELECT COUNT(idLajk) FROM lajkovi l WHERE p.idPosta=l.idPosta) as brojLajkova,(SELECT COUNT(idKomentar) FROM komentari k WHERE k.idPosta=p.idPosta) AS brojKomentara FROM postovi p ORDER BY datum DESC LIMIT 3";

    
    try{  
        $postovi=$konekcija->query($upit)->fetchAll();
        $code=200;
    }
    catch(PDOException $e){
        $code=500;
        $data="Server error";
    }

    
?>
