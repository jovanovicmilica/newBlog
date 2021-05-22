<?php
    require_once "model/post.php";
?>
<main>
    <div class="container pt-5 text-center">
        <div class="row pt-5">
            <?php
                if(isset($naslov)):
            ?>
                <h1><?=$naslov?></h1>
            <?php
                else:
            ?>
                <h1><?=$post['naslov']?></h1>
            <?php
                endif;
            ?>
        </div>
    </div>
    <?php
        if(!isset($naslov)):
    ?>
        <div class="container postovi">
            <div class="row">
                <div class="col-12 col-md-10 mx-auto my-3">
                    <img src="assets/images/<?=$post['slikasrc']?>" alt="<?=$post['naslov']?>">
                </div>
                <div class="col-12 col-md-10 mx-auto my-3">
                    <p><?=$post['tekst']?></p>
                </div>
                <div class="col-12 col-md-10 border mx-auto p-3 my-5 rounded">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between rounded-0 p-2 border-bottom my-2">
                            <div>
                                <span id="brojKomentara"></span>
                                <i class="far fa-comment-alt text-primary"></i>
                            </div>
                            <div>
                                <span id="brojLajkova"></span>
                                <a href="" id="srce">
                                    <i class="far fa-heart text-danger" id="prazno"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row" id="komentari">
                        </div>
                        <div class="col-12 my-2">
                            <form action="">
                                <input type="hidden" id="idPosta" value="<?=$_GET['id']?>">
                            <?php
                                if(isset($_SESSION['user'])):
                            ?>
                                <textarea placeholder="Write comment" id="commentText" class="col-12 form-control"></textarea>
                                <p></p>
                                <input type="button" value="Post comment" id="btnComment" class="btn btn-primary mt-2">
                                <p id="greskaComm"></p>
                            </form>

                        <?php
                            else:
                        ?>
                            <p>Login to post comment!</p>
                        <?php
                            endif;
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
        endif;
    ?>
</main>