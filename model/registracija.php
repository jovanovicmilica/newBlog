<?php

    require_once "konekcija.php";

    $data="";

    if(isset($_POST['dugme'])){
        
        $ime=$_POST['ime'];
        $prezime=$_POST['prezime'];
        $mail=$_POST['email'];
        $pass=$_POST['pass'];
        $passConf=$_POST['passConf'];
        
        $regIme="/^[A-Z][a-z]{2,29}$/";
        $regPrezime="/^[A-Z][a-z]{2,39}$/";
        $regEmail="/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/";
        $regPass="/^.{8,50}$/";
        $greske=[];
        if(!preg_match($regIme,$ime)){
            //array_push($greske,"Ime mora početi velikim slovom");
            $greske['greskaime']="First name must begin with a capital letter (maximum 30 characters)";
        }
        if(!preg_match($regPrezime,$prezime)){
            //array_push($greske,"Prezime mora početi velikim slovom");
            $greske['greskaprezime']="Last name must begin with a capital letter (maximum 40 characters)";
        }
        if(!preg_match($regEmail,$mail)){
            //array_push($greske,"Format e-maila: milica.jovanovic.88.18@ict.edu.rs");
            $greske['greskamail']="E-mail format: milica.jovanovic.88.18@ict.edu.rs or milica@gmail.com";
        }
        if(!preg_match($regPass,$pass) && strlen($pass)<8){
            //array_push($greske,"Lozinka mora imati barem 8 karaktera");
            $greske['greskapss']="Password must be at least 8 characters long";
        }
        if($passConf!=$pass){
           //array_push($greske,"Lozinke se ne poklapaju");
            $greske['greskapassconf']="Passwords do not match";
        }
      
        $mailProvera="SELECT email FROM korisnici WHERE email=:mail";
        $priprema=$konekcija->prepare($mailProvera);
        $priprema->bindParam(":mail",$mail);
        try{
            $priprema->execute();
            $rez=$priprema->fetch();
            if($priprema->rowCount()==1){
                $data="There is already a user with that email address";
                $code=200;
            }
            else{
                if(count($greske)==0){

                    $insert="INSERT INTO korisnici VALUES(NULL,:ime,:prezime,:mail,:pass,:aktivan,:aktivacionikod,:datum,:iduloge)";
                    $pass=md5($pass);
                    $datum=date("Y-m-d H:i:s");
                    $uloga=2;
                    $aktivan=0;
                    $kod=md5(time().md5($mail));
                    
                    //mail($mail,"Account activation","http://127.0.0.1/blogsajt/activation.php?code=".$kod);

                    
                    $priprema2=$konekcija->prepare($insert);
                    $priprema2->bindParam(":ime",$ime);
                    $priprema2->bindParam(":prezime",$prezime);
                    $priprema2->bindParam(":mail",$mail);
                    $priprema2->bindParam(":pass",$pass);
                    $priprema2->bindParam(":aktivan",$aktivan);
                    $priprema2->bindParam(":aktivacionikod",$kod);
                    $priprema2->bindParam(":datum",$datum);
                    $priprema2->bindParam(":iduloge",$uloga);
                    try{
                        $uspesno=$priprema2->execute();
                        $code=201;
                        $data="You have successfully registered, check your email to activate your account";
                    }
                    catch(PDOException $e){
                        $code=500;
                        $data="Server error";
                    }
                }
                else{
                    $data=$greske;
                    $code=422;
                }
            }
        }
        catch(PDOException $e){
            $data= "Server error";
            $code=500;
        }
    
    }
    else{
        $code=404;
        $data="Error";
    }

echo json_encode($data);
http_response_code($code);
?>