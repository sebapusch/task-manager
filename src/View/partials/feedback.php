<div class="container alert w-75 mx-auto my-5 alert-<?php if($success) { echo 'success'; } else { echo 'danger'; } ?>"
     id = "feedback"
     role="alert">
        <?= $this->escape($message) ?>
</div>

