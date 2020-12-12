
<form method="post" action="<?= $this->escape($action) ?>" class="m-0">

        <?php if(isset($task)) { ?>
            <input type="number" name="id" value="<?= $this->escape($task['id']) ?>" hidden>
        <?php } ?>

        <div class="row g-0">
            <div class="form-floating col-4">
                <input type="text"
                       class="form-control"
                       id="title"
                       name="title"
                        placeholder="Titolo"
                       value="<?php if(isset($task)) { echo $this->escape($task['title']); } ?>">
                <label for="title">Titolo</label>
            </div>
            <div class="form-floating col-7">
                <textarea type="text"
                       class="form-control"
                       id="content"
                       name="content"
                        placeholder="Contenuto"><?php if(isset($task)) { echo $this->escape($task['content']); } ?></textarea>
                <label for="content">Contenuto</label>
            </div>
            <div class="col-1">
                <button class="btn btn-outline-primary w-100 h-100" type="submit"><?= $this->escape($button) ?></button>
            </div>
        </div>
    </form>