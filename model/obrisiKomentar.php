<?php

    require_once "konekcija.php";

    if(isset($_POST['dugme'])){

        $id=$_POST['id'];
        $data="";

        $upit="DELETE FROM komentari WHERE idKomentar=:id";
        $priprema=$konekcija->prepare($upit);
        $priprema->bindParam(":id",$id);
        
        try{  
            $priprema->execute();
            $data="Deleted successfully";
            $code=200;
        }
        catch(PDOException $e){
            $code=500;
            $data="Server error";
        }
    }
    else{
        $data="Error";
        $code=404;
    }

    
echo json_encode($data);
http_response_code($code);
?>
