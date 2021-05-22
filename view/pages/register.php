<?php

?>
<div class="container-fluid pt-5">
    <div class="row text-center pt-5">
        <h1>Register</h1>
    </div>
</div>
<div class="container">
    <form action="">
    <div class="row">
        <div class="col-7 col-xs-10 mx-auto mt-3">
            <label for="fname">First name</label>
            <input type="text" id="fName" class="form-control">
            <p id="porukaFName"></p>
        </div>
        <div class="col-7 col-xs-10 mx-auto mt-3">
            <label for="lName">Last name</label>
            <input type="text" id="lName" class="form-control">
            <p id="porukaLName"></p>
        </div>
        <div class="col-md-7 col-xs-10 mx-auto mt-3">
            <label for="email">E-mail</label>
            <input type="text" id="email" class="form-control">
            <p id="porukaEmail"></p>
        </div>
        <div class="col-md-7 col-xs-10 mx-auto mt-3">
            <label for="pass">Password</label>
            <input type="password" id="pass" class="form-control">
            <p id="porukaPass"></p>
        </div>
        <div class="col-md-7 col-xs-10 mx-auto mt-3">
            <label for="passConfirm">Confirm password</label>
            <input type="password" id="passConfirm" class="form-control">
            <p id="porukaPassConf"></p>
        </div>
        <div class="col-md-7 col-xs-10 mx-auto my-3">
            <input type="button" id="btnRegister" value="Register" class="btn btn-primary">
            <p id="porukaReg"></p>
        </div>
    </form>
    </div>
</div>