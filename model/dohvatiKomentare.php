<?php
  
    require_once "konekcija.php";

    if(isset($_GET['id'])){
        
        $post=$_GET['id'];
        $upit="SELECT * FROM komentari k INNER JOIN korisnici ko ON ko.idKorisnika=k.idKorisnika WHERE k.idPosta=:id";


        $priprema=$konekcija->prepare($upit);

        $priprema->bindParam(":id",$post);
        try{
            $priprema->execute();
            $rezultat=$priprema->fetchAll();
            if($priprema->rowCount()!=0){
                $data= $rezultat;
                $kod=200;
            }
            else{
                $kod=200;
                $data="No comments yet";
            }
        }
        catch(PDOException $e){
            $kod=500;
            $data="Server error";
            
        }
    }
    else{
        $kod=404;
        $data="Error 404";
    }


http_response_code($kod);
echo json_encode($data);
    
?>