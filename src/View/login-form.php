<?php $this->layout('layout', ['title' => 'login']); ?>

<?php if(isset($feedback)) { $this->insert('partials/feedback', $feedback); } ?>

<div class="row">
    <span class="col-sm-0 col-lg-3"></span>
    <form method="post" class="col-sm-12 col-lg-6">
        <div class="form-floating m-3">
            <input type="email"
                   class="form-control <?php if(isset($feedback)) { echo 'is-invalid'; }?>"
                   id="email"
                   name="email"
                   placeholder="Email"
                   value="<?php if(! empty($email)) { echo $email; }?>"">
            <label for="email">Email</label>
        </div>

        <div class="form-floating m-3">
            <input type="password"
                   class="form-control <?php if(isset($feedback)) { echo 'is-invalid'; }?>"
                   id="password"
                   placeholder="Password"
                   name="password">
            <label for="password">Password</label>
        </div>

        <button type="submit" class="btn btn-primary m-3">Login</button>

        <br>

        <a class="m-3" href="/register">registrati</a>
    </form>
    <span class="col-sm-0 col-lg-3"></span>
</div>
