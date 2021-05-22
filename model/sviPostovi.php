<?php

    require_once "konekcija.php";


    $key="";
    $strana=0;
    $limit=2;
    $offset=0;
    $ukupno=0;
    if(isset($_GET['q'])){
        $key=$_GET['q'];
    }
    if(isset($_GET['p'])){
        $strana=$_GET['p']-1;
        $offset=$strana*$limit;
    }


    $data="";
    $upit="SELECT *,LEFT(tekst,250) AS tekst,(SELECT COUNT(idLajk) FROM lajkovi l WHERE p.idPosta=l.idPosta) as brojLajkova,(SELECT COUNT(idKomentar) FROM komentari k WHERE k.idPosta=p.idPosta) AS brojKomentara FROM postovi p WHERE naslov LIKE '%$key%'";

    
    try{  
        $executeUpit=$konekcija->query($upit);
        if($executeUpit->rowCount()!=0){
            $ukupno=$executeUpit->rowCount();
        }
        else{
            $greska="There is not match";
        }
        $code=200;
        $brojStrana=ceil($ukupno/$limit);

        $upit.="LIMIT $limit OFFSET $offset";
        $postovi=$konekcija->query($upit)->fetchAll();

    }
    catch(PDOException $e){
        $code=500;
        $greska="Server error";
    }

    
?>
