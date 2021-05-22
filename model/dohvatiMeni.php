<?php
    session_start();
    require_once "konekcija.php";

    $data="";
    if(isset($_SESSION['user'])){
        //admin 1
        $korisnik=$_SESSION['user'];
        if($korisnik['idUloge']==1){
            $prikaz=3;
        }
        else{
            $prikaz=2;
        }
    }
    else{
        $prikaz=1;
    }

    $upit="SELECT * FROM meni WHERE prikaz=1";

    if($prikaz==3){
        //admin
        $upit.="  OR prikaz=3 OR prikaz=2";
    }
    else if($prikaz==2){
        //obican korisnik
        $upit.=" OR prikaz=2 OR prikaz=4";
    }
    else{
        //neautorizovan korisnik korisnik
        $upit.=" OR prikaz=0";
        
    }
    $upit.=" ORDER BY prioritet";

    try{  
        $rezultatMeni=$konekcija->query($upit)->fetchAll();
        //var_dump($rezultatMeni);
        $data=$rezultatMeni;
        $code=200;
    }
    catch(PDOException $e){
        $code=500;
        $data="Server error";
    }
    

    
echo json_encode($data);
http_response_code($code);

?>