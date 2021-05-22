<?php

    require_once "konekcija.php";
    $code=200;
        $data=[];


        $upit="SELECT * FROM anketa";
        
        try{  
            $rez=$konekcija->query($upit)->fetch();
            $data['pitanje']=$rez;
            $idAnkete=$rez['idAnkete'];
            $data['aktivna']=$rez['aktivna'];
            $upit2="SELECT *,ROUND(((SELECT COUNT(idOdgovorAnketa) FROM odgovorianketa oa WHERE oa.idOdgovora=o.idOdgovora)/(SELECT COUNT(idOdgovorAnketa) FROM odgovorianketa oa INNER JOIN odgovori o ON oa.idOdgovora=o.idOdgovora))*100.2) AS broj FROM odgovori o WHERE idAnkete=$idAnkete";

            try{
                $rez2=$konekcija->query($upit2)->fetchAll();
                $data['odgovori']=$rez2;
            }
            catch(PDOException $e){
                $code=500;
                $data=$e;
            }
        }
        catch(PDOException $e){
            $code=500;
            $data="Server error";
        }

    
echo json_encode($data);
http_response_code($code);
?>
