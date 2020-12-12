<?php
declare(strict_types=1);

namespace SimpleMVC\Controller;


use League\Plates\Engine;
use Psr\Http\Message\ServerRequestInterface;
use SimpleMVC\Model\User;

class Login implements ControllerInterface
{
    protected Engine $engine;
    private User $user;

    function __construct(Engine $plates, User $user)
    {
        $this->engine = $plates;
        $this->user = $user;
    }

    public function execute(ServerRequestInterface $request)
    {
        if($this->user->isLogged()) {
            header('Location: /dashboard');
            die();
        }

        if($request->getMethod() === 'GET') {
            echo $this->engine->render('login-form');
            return;
        }

        $postData = $request->getParsedBody();
        if(false  === $this->user->login($postData['email'], $postData['password'])) {
            echo $this->engine->render('login-form', ['feedback' => [
                'success' => false,
                'message' => 'credenziali errate'
            ]]);
            return;
        }

        header('Location: /dashboard');
        die();
    }
}