<?php
    require_once "model/dohvatiKategorije.php";
    require_once "model/dohvatiSponzore.php";
    require_once "model/dohvatiNajnovije.php";
    require_once "model/dohvatiAnketu.php";
?>
<main>
<div class="containter-fluid" id="gore">
    <div class="row">
        <div class="col-12 gore d-flex justify-content-center align-items-center flex-column text-light">
            <h1>Travel Blog<h1>
            <h2>Going Places<h2>
            <p>I haven’t been everywhere, but it’s on my list</p>
        </div>
    </div>
</div>
<div class="container-fluid py-5">
    <div class="row justify-content-around text-center text-light">
    <?php
        foreach($kategorije as $k):
    ?>
        <div class="col-md-3 col-sm-7 my-3">
            <div  class="kategorija">
                <img src="assets/images/<?=$k['slikasrc']?>" alt="<?=$k['naziv']?>">
                <p class="py-2"><?=$k['naziv']?></p>
            </div>
        </div>
    <?php
        endforeach;
    ?>
    </div>
</div>
<div class="container-fluid bg-light my-5">
    <div class="row text-center featured py-4">
        <div class="col-12 col-sm-3">
            <p class="border-end border-secondary p-3 border-sm">As featured by</p>
        </div>
        <?php
            foreach($sponzori as $s):
        ?>
            <div class="col p-3">
                <p><?=$s['naziv']?></p>
            </div>
        <?php
            endforeach;
        ?>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col text-center mb-5">
            <h2>Latest posts</h2>
        </div>
    </div>
</div>
<div class="container postovi">
    <div class="row" id="najnoviji">
            <?php
                foreach($postovi as $p):
            ?>
            <div class="mb-5 col-10 mx-auto px-2 text-justify">
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
            ?>
    </div>
</div>
<?php
    if(isset($_SESSION['user'])):
?>
<div class="container-fluid my-5">
    <div class="row text-center">
        <?php
            if(isset($greskaAnketa)):
        ?>
            <h2><?=$greskaAnketa?></h2>
        <?php
            else:
        ?>
            <h2><?=$pitanje['pitanje']?></h2>
            <div class="row">
            <form action="">
                <input type="hidden" value="<?=$pitanje['idAnkete']?>" id="idAnketa">
                <div class="col-12 my-3">
            <?php
                foreach($odgovori as $o):
            ?>
                    <input name="rbAnketa" type="radio" value="<?=$o['idOdgovora']?>"><span class="mx-2"><?=$o['tekstOdgovora']?></span>
            <?php
                endforeach;
            ?>
                </div>
                <div class="col-12 my-2">
                    <input type="button" id="btnAnketa" value="Vote" class="btn btn-primary">
                </div>
            </div>
            </form>
        <?php
            endif;
        ?>
    </div>
</div>
<?php
    endif;
?>
<div class="containter-fluid bg-primary p-5">
    <div class="row text-center">
            <div class="col">
                <a href="" class="text-light text-decoration-none"><i class="fab fa-facebook-f"></i> Facebook</a>
            </div>
            <div class="col">
                <a href="" class="text-light text-decoration-none"><i class="fab fa-instagram"></i> Instagram</a>
            </div>
            <div class="col">
                <a href="" class="text-light text-decoration-none"><i class="fab fa-youtube"></i> Youtube</a>
            </div>
            <div class="col">
                <a href="" class="text-light text-decoration-none"><i class="fab fa-pinterest"></i> Pinterest</a>
            </div>
            <div class="col">
                <a href="" class="text-light text-decoration-none"><i class="fab fa-twitter"></i> Twitter</a>
            </div>
    </div>
</div>
<div class="containter-fluid">
    <div class="row slicice">
        <div class="col-6 col-md-3 p-0">
            <img class="rounded-0" src="assets/images/slika1.jpeg" alt="">
        </div>
        <div class="col-6 col-md-3 p-0">
            <img class="rounded-0" src="assets/images/slika2.jpeg" alt="">
        </div>
        <div class="col-6 col-md-3 p-0">
            <img class="rounded-0" src="assets/images/slika3.jpeg" alt="">
        </div>
        <div class="col-6 col-md-3 p-0">
            <img class="rounded-0" src="assets/images/slika4.jpeg" alt="">
        </div>
    </div>
</div>
</main>