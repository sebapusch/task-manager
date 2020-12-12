<?php
declare(strict_types=1);

namespace SimpleMVC\Controller;


use Psr\Http\Message\ServerRequestInterface;
use SimpleMVC\Model\User;

class Logout implements ControllerInterface
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function execute(ServerRequestInterface $request)
    {
        if($this->user->isLogged()) {
            $this->user->logout();
        }
        header('Location: /login');
        die();
    }
}