<?php
    require_once "parametri.php";

    try{
        $konekcija=new PDO("mysql:host=$host;dbname=$baza",$user,$pass,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'"));
        $konekcija->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }
?>