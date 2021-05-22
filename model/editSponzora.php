<?php
    require_once "konekcija.php";
    $data="";
    $kod=200;
    $greske=0;

    if(isset($_POST['dugme'])){
        $name=$_POST['name'];
        $id=$_POST['id'];

        $regName="/^[A-z\s\d]{2,15}$/";
        
        if(!preg_match($regName,$name)){
            $data="Name has 2 letters minimum, 15 maximum";
            $greske++;
        }

        if($greske==0){
            $daLiPostoji="SELECT * FROM sponzori WHERE naziv LIKE '$name'";
            try{
                $rez=$konekcija->query($daLiPostoji);
                if($rez->rowCount()==1){
                    $data="Sponsor already exist";
                }
                else{
                    $upit="UPDATE sponzori SET naziv=:naziv WHERE idSponzor=:id";
                    $priprema=$konekcija->prepare($upit);
                    $priprema->bindParam(":naziv",$name);
                    $priprema->bindParam(":id",$id);
                    try{
                        $priprema->execute();
                        $data="Sponsor successfuly updated";
                    }
                    catch(PDOException $e){
                        $poruka="Server error";
                        $kod=500;
                    }
                }

            }
            catch(PDOException $e){
                $data="Server error";
                $kod=500;
            }
        }

    }
    else{
        $data="Error";
        $kod=404;
    }

    
    
echo json_encode($data);
http_response_code($kod);
?>