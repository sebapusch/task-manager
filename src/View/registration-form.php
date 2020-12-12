<?php $this->layout('layout', ['title' => 'registrazione']); ?>

<?php if(isset($feedback)) { $this->insert('partials/feedback', $feedback); } ?>

<div class="row">

    <span class="col-sm-0 col-lg-3"></span>

    <form method="post" class="col-sm-12 col-lg-6">
        <div class="form-floating m-3">
            <input type="email"
                 class="form-control <?php if(isset($feedback['fields']) && $feedback['fields']['email'] === false) { echo 'is-invalid'; }?>"
                 id="email"
                 name="email"
                 placeholder="Email"
                value="<?php if(isset($feedback['fields']) && $feedback['fields']['email'] !== false) { echo $this->escape($feedback['fields']['email']); }?>"">
            <label for="email">Email</label>
        </div>

        <div class="form-floating m-3">
            <input type="text"
                   class="form-control <?php if(isset($feedback['fields']) && $feedback['fields']['nickname'] === false) { echo 'is-invalid'; }?>"
                   id="nickname"
                   name="nickname"
                   placeholder="Password"
                   value="<?php if(isset($feedback['fields']) && $feedback['fields']['nickname'] !== false) { echo $this->escape($feedback['fields']['nickname']); }?>"">
            <label for="nickname">Nickname</label>
        </div>

        <div class="form-floating m-3">
            <input type="password"
                   class="form-control <?php if(isset($feedback['fields']) && $feedback['fields']['password'] === false) { echo 'is-invalid'; }?>"
                   id="password"
                   placeholder="Password"
                    name="password">
            <label for="password">Password</label>
        </div>

        <button type="submit" class="btn btn-primary m-3">Registrati</button>

        <br>

        <a class="m-3" href="/login">effettua il login</a>
    </form>

    <span class="col-sm-0 col-lg-3"></span>

</div>