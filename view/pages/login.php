<?php

?>
<div class="container-fluid pt-5">
    <div class="row text-center pt-5">
        <h1>Login</h1>
    </div>
</div>
<div class="container">
    <div class="row">
    <form action="">
        <div class="col-md-6 col-xs-10 mx-auto mt-3">
            <label for="email">E-mail</label>
            <input type="text" id="email" class="form-control">
            <p id="porukaEmail"></p>
        </div>
        <div class="col-md-6 col-xs-10 mx-auto mt-3">
            <label for="pass">Password</label>
            <input type="password" id="pass" class="form-control">
            <p id="porukaPass"></p>
        </div>
        <div class="col-md-6 col-xs-10 mx-auto my-3">
            <input type="button" id="btnLogin" value="Login" class="btn btn-primary">
            <p id="porukaLog"></p>
        </div>
    </form>
    </div>
</div>