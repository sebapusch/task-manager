<?php
use SimpleMVC\Controller;

return [
    [ 'GET', '/', Controller\Home::class ],
    ['GET', '/register', Controller\Register::class],
    ['POST', '/register', Controller\Register::class],
    ['GET', '/login', Controller\Login::class],
    ['POST', '/login', Controller\Login::class],
    ['GET', '/dashboard', Controller\Dashboard::class],
    ['POST', '/dashboard/{action}', Controller\Dashboard::class],
    ['GET', '/logout', Controller\Logout::class]
];
