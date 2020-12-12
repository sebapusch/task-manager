<?php


namespace SimpleMVC\Controller;


use League\Plates\Engine;
use Psr\Http\Message\ServerRequestInterface;
use SimpleMVC\Exception\DuplicateEntryException;
use SimpleMVC\Model\User;

class Register implements ControllerInterface
{
    protected Engine $engine;
    protected User $user;

    function __construct(Engine $plates, User $user)
    {
        $this->engine = $plates;
        $this->user = $user;
    }

    public function execute(ServerRequestInterface $request)
    {
        if($this->user->islogged()) {
            header('Location: /dashboard');
            die();
        }

        if($request->getMethod() === 'GET') {
            echo $this->engine->render('registration-form');
            return;
        }

        $postData = $request->getParsedBody();
        $feedback = $this->validate($postData);

        if($feedback['success'] === true) {
            try {
                $this->user->register($postData['email'], $postData['nickname'], $postData['password']);
            } catch (DuplicateEntryException $e) {
                $feedback['success'] = false;
                $feedback['message'] = 'questa email è già associata ad un account';
                $feedback['fields']['email'] = false;
            }
        }

        if($feedback['success'] === false) {
            echo $this->engine->render('registration-form', ['feedback' => $feedback, 'data' => $postData]);
            return;
        }

        header('Location: /dashboard');
        die();
    }

    private function validate(array $postData)
    {
        $message = '';

        if(empty($postData['password']) || strlen($postData['password']) < 8) {
            $message = 'la tua password deve contenere almeno 8 caratteri,';
            $fields['password'] = false;
        }

        if(empty($postData['nickname']) || strlen($postData['nickname']) < 4) {
            $message .= ' il tuo nickname deve contenere almeno 4 caratteri,';
            $fields['nickname'] = false;
        } else {
            $fields['nickname'] = $postData['nickname'];
        }

        $email = filter_var($postData['email'], FILTER_VALIDATE_EMAIL);
        if(false === $email) {
            $message .= ' la tua email non è valida';
            $fields['email'] = false;
        } else {
            $fields['email'] = $postData['email'];
        }

        if($message === '') {
            return [
                'success' => true,
                'fields' => $fields
            ];
        }

        return [
            'success' => false,
            'message' => $message,
            'fields' => $fields
        ];
    }
}