<?php $this->layout('layout', ['title' => 'dashboard']); ?>

<div class="container w-75 mx-auto mt-5">
    <div class="row">
        <div class="col-8">
            <p class="lead">Ciao <?= $this->escape($nickname) ?>, benvenuto nella tua dashboard</p>
        </div>
        <div class="col-4 text-end">
            <a class="lead" href="/logout">Logout</a>
        </div>
    </div>
</div>

<?php if(! empty($feedback)) { $this->insert('partials/feedback', $feedback); } ?>

<div class="row p-0 my-5 g-0">

    <span class="col-sm-0 col-lg-1"></span>

    <div class="accordion col-sm-12 col-lg-10" id="tasks">

        <?php foreach ($tasks as $task) { ?>

        <div class="accordion-item">
            <h2 class="accordion-header" id="heading<?= $task['id'] ?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $task['id'] ?>" aria-expanded="true" aria-controls="collapse<?= $this->escape($task['id']) ?>">
                    <div class="row w-100">
                        <div class="col-8 text-start">
                            <?= $this->escape($task['title']) ?>
                        </div>
                        <div class="col-4 text-start">
                            <?= $this->escape($task['insertion_time']) ?>
                        </div>
                    </div>
                </button>
            </h2>
            <div id="collapse<?= $this->escape($task['id']) ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $this->escape($task['id']) ?>" data-bs-parent="#tasks">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-9">
                            <?= $task['content'] ?>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-outline-primary open-form-button">Aggiorna</button>

                            <form action="/dashboard/delete" class="d-inline" method="post">
                                <input type="number" name="id" value="<?= $this->escape($task['id']) ?>" hidden>
                                <button type="submit" class="btn btn-outline-danger">Elimina</button>
                            </form>
                        </div>
                    </div>

                    <div class="row g-0 d-none">
                        <div class="col-11">
                            <?php $this->insert('partials/task-form', [ 'action' => '/dashboard/update',
                                                                        'button' => 'Aggiorna',
                                                                        'task' => $task]); ?>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-outline-danger close-form-button w-100 h-100">Annulla</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <?php } ?>

        <?php $this->insert('partials/task-form', ['action' => '/dashboard/insert', 'button' => 'Aggiungi'])?>

    </div>

    <span class="col-sm-0 col-lg-1"></span>

</div>
<script src="/assets/js/dashboard.js"></script>
