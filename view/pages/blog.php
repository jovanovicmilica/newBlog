<?php
    require_once "model/sviPostovi.php";
?>
<main>
    <div class="container-fluid pt-5">
        <div class="row text-center pt-5">
            <h1>Posts</h1>
        </div>
    </div>
    <div class="container my-3">
        <div class="row">
            <div class="col-10 mx-auto">
                <form action="<?=$_SERVER['PHP_SELF']?>">
                    <div class="row justify-content-between">
                        <div class="col-8">
                            <input type="text" name="q" 
                            <?php
                                if(isset($_GET['q'])):
                            ?>
                                value="<?=$_GET['q']?>"
                            <?php
                                endif;
                            ?>
                             placeholder="Search post" class="form-control">
                        </div>
                        <div class="col-3">
                            <input type="submit" value="Search" class="col-12 btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container postovi">
        <div class="row">
            <?php
            if(!isset($greska)):
                foreach($postovi as $p):
            ?>
            <div class="mb-5 col-10 mx-auto text-justify">
                <img src="assets/images/<?=$p['slikasrc']?>" alt="">
                <div class="border border-top-0 p-4">
                    <p class="py-2"><?=$p['datum']?></p>
                    <h2 class="py-1"><?=$p['naslov']?></h2>
                    <p class="py-2"><?=$p['tekst']?> <a href="<?="post.php?id=".$p['idPosta']?>">Contrinue reading</a></p>
                    <div class="d-flex justify-content-between border-top py-2">
                        <p><?=$p['brojKomentara']?> <i class="far fa-comment-alt text-primary"></i></p>
                        <p><?=$p['brojLajkova']?> <i class="far fa-heart text-danger"></i></p>
                    </div>
                </div>
            </div>
            <?php
                endforeach;
            else:
            ?>
            <div class="col-10 mx-auto">
                <p class="py-2"><?=$greska?></p>
            </div>
            <?php
                endif;
            ?>
        </div>
    </div>
    <?php
        if(!isset($greska)):
    ?>
    <div class="container">
        <div class="row">
            <div class="col-10 mx-auto text-center">
                <?php
                $trenutna=1;
                $sledeca=2;
                $pretraga="";
                    if(isset($_GET['q'])){
                        $pretraga=$_GET['q'];
                    }
                    if(isset($_GET['p'])){
                        $trenutna=$_GET['p'];
                        $sledeca=$trenutna+1;
                        $prethodna=$trenutna-1;
                    }
                    if($trenutna!=1):
                ?>

                    <a class="text-decoration-none fs-5" href="<?=$_SERVER['PHP_SELF']."?p=".$prethodna."&q=".$pretraga?>">Previous</a>
                <?php
                    endif;
                ?>
                <?php
                    for($i=0;$i<$brojStrana;$i++):
                    $strana=$i+1;
                ?>
                    <a class="text-decoration-none fs-5" href="<?=$_SERVER['PHP_SELF']."?p=".$strana."&q=".$pretraga?>"><?=$strana?></a>
                <?php
                    endfor;
                ?>
                <?php
                    if($trenutna!=$brojStrana):
                ?>
                    <a class="text-decoration-none fs-5" href="<?=$_SERVER['PHP_SELF']."?p=".$sledeca."&q=".$pretraga?>">Next</a>
                <?php
                    endif;
                ?>
            </div>
        </div>
    </div>
    <?php
        endif;
    ?>
</main>