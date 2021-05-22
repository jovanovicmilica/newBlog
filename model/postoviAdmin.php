<?php
    require_once "konekcija.php";

    $data="";
    $code=200;
        $upit="SELECT p.*,(SELECT COUNT(idKomentar) FROM komentari k WHERE k.idPosta=p.idPosta) AS brojKomentara,(SELECT COUNT(idLajk) FROM lajkovi l WHERE l.idPosta=p.idPosta) AS brojLajkova FROM postovi p";
        $priprema=$konekcija->prepare($upit);
        try{
            $priprema->execute();
            if($priprema->rowCount()!=0){
                $post=$priprema->fetchAll();
                $data=$post;
            }
            else{
                $data="There is no posts";
            }
        }
        catch(PDOException $e){
            $code=500;
            $data="Server error";
        }

http_response_code($code);
echo json_encode($data);
?>