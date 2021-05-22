<?php
    require_once "konekcija.php";
    $data="";
    $code=200;

    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $upit="SELECT COUNT(idKomentar) AS brojKomentara FROM komentari WHERE idPosta=:id";
        $priprema=$konekcija->prepare($upit);
        $priprema->bindParam(":id",$id);
        try{
            $priprema->execute();
            if($priprema->rowCount()==1){
                $post=$priprema->fetch();
                $data=$post;
            }
            else{
                $data="Nemate pristup";
                $code=404;
            }
        }
        catch(PDOException $e){
            $code=500;
            $data="Server error";
        }
    }
    else{
        $data="Nemate pristup";
        $code=500;
    }


http_response_code($code);
echo json_encode($data);
?>