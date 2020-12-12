<?php
declare(strict_types=1);

namespace SimpleMVC\Controller;

use League\Plates\Engine;
use League\Plates\Extension\Asset;
use Psr\Http\Message\ServerRequestInterface;
use SimpleMVC\Model\Task;
use SimpleMVC\Model\User;

class Dashboard implements ControllerInterface
{
    protected Engine $engine;

    private Task $task;
    private User $user;

    function __construct(Engine $plates, Task $task, User $user/*, Asset $assetExtension*/)
    {
        $this->engine = $plates;
        //$this->engine->loadExtension($assetExtension); ho tentato questo approccio ma non so per quale motivo non funziona
        $this->task = $task;
        $this->user = $user;
    }

    /**
     * Redirects requests for task CRUD operations
     *
     * Redirects the user to login page if he is not logged in.
     * Performs required operation if HTTP method is POST.
     * Displays dashboard view passing all tasks.
     *
     * @param ServerRequestInterface $request
     * @throws \SimpleMVC\Exception\UserNotLoggedException
     */
    public function execute(ServerRequestInterface $request)
    {
        if(false === $this->user->isLogged()) {
            header('Location: /login');
            die();
        }

        $action = $request->getAttribute('action', null);
        $feedback = [];

        if($request->getMethod() === 'POST') {
            switch ($action) {
                case 'insert':
                    $feedback = $this->insert($request->getParsedBody());
                    break;
                case 'update':
                    $feedback = $this->update($request->getParsedBody());
                    break;
                case 'delete':
                    $feedback = $this->delete($request->getParsedBody());
                    break;
            }
        }

        $tasks = $this->task->findAll($this->user->getNickname());
        echo $this->engine->render('dashboard', ['tasks' => $tasks,
                                                        'feedback' => $feedback,
                                                        'nickname' => $this->user->getNickname()]);
    }

    private function insert(array $postData) : array
    {
        if( ! empty($postData['title']) &&
            ! empty($postData['content']) &&
            $this->task->insertOne($postData, $this->user->getNickname()))
        {
            return [
                'success' => true,
                'message' => 'task inserito con successo'
            ];
        }

        return [
            'success' => false,
            'message' => 'impossibile inserire task'
        ];
    }

    private function update(array $postData) : array
    {
        if( ! empty($postData['title']) &&
            ! empty($postData['content']) &&
            ! empty($postData['id']) &&
            $this->task->updateOne($postData, $this->user->getNickname()))
        {
            return [
                'success' => true,
                'message' => 'task aggiornato con successo'
            ];
        }

        return [
            'success' => false,
            'message' => 'impossibile aggiornare task'
        ];
    }

    private function delete(array $postData) : array
    {
        if(! empty($postData['id']) && $this->task->deleteOne((int)$postData['id'], $this->user->getNickname())) {
            return [
                'success' => true,
                'message' => 'task eliminato con successo'
            ];
        }

        return [
            'success' => false,
            'message' => 'impossibile eliminare task'
        ];
    }
}