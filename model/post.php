<?php
    require_once "konekcija.php";

    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $upit="SELECT * FROM postovi WHERE idPosta=:id";
        $priprema=$konekcija->prepare($upit);
        $priprema->bindParam(":id",$id);
        try{
            $priprema->execute();
            if($priprema->rowCount()==1){
                $post=$priprema->fetch();
            }
            else{
                $naslov="Nemate pristup";
            }
        }
        catch(PDOException $e){
            $code=500;
            $data="Server error";
        }
    }
    else{
        echo "Nemate pristup";
    }
?>