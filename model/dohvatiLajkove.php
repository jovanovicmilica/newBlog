<?php
session_start();
    require_once "konekcija.php";
    $data=[];
    $code=200;
    $data['lajkovao']=false;

    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $upit="SELECT COUNT(idLajk) AS brojLajkova FROM lajkovi WHERE idPosta=:id";
        $priprema=$konekcija->prepare($upit);
        $priprema->bindParam(":id",$id);
        try{
            $priprema->execute();
            if($priprema->rowCount()==1){
                $post=$priprema->fetch();
                $data['lajk']=$post;
                if(isset($_SESSION['user'])){
                    $user=$_SESSION['user'];
                    $idUser=$user['idKorisnika'];
                    $upit2="SELECT * FROM lajkovi WHERE idPosta=:idPost AND idKorisnika=:idKorisnik";
                    $priprema2=$konekcija->prepare($upit2);
                    $priprema2->bindParam(":idPost",$id);
                    $priprema2->bindParam(":idKorisnik",$idUser);
                    try{
                        $priprema2->execute();
                        if($priprema2->rowCount()==1){
                            $data['lajkovao']=true;
                        }
                        else{
                            $data['lajkovao']=false;
                        }
                    }
                    catch(PDOException $e){
                        $code=500;
                        $data="Server error";
                    }
                }
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