<?php

    require_once "view/fixed/head.php";

    require_once "view/fixed/header.php";


    if(!isset($_SESSION['user'])){
        require_once "view/pages/login.php";
    }
    else{
        require_once "view/pages/page404.php";
    }

    require_once "view/fixed/footer.php";

?>