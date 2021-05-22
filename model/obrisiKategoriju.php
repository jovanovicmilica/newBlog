<?php

    require_once "konekcija.php";


        $id=$_POST['id'];
        $data="";


        $upit="DELETE FROM kategorije WHERE idKategorije=:id";
        $priprema=$konekcija->prepare($upit);
        $priprema->bindParam(":id",$id);
        
        try{  
            $priprema->execute();
            $data="Deleted successfully";
            $code=204;
        }
        catch(PDOException $e){
            $code=500;
            $data="Server error";
        }

    
echo json_encode($data);
http_response_code($code);
?>
