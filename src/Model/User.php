<?php
declare(strict_types=1);

namespace SimpleMVC\Model;

use SimpleMVC\Exception\DuplicateEntryException;
use SimpleMVC\Exception\UserNotLoggedException;

class User extends BaseModel
{
    /**
     * Verifies user passed credentials and stores nickname inside session if they are correct
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login(string $email, string $password) : bool
    {
        $user = $this->find(
            'users', [
                'columns' => ['nickname', 'password'],
                'conditions' => 'email = :email',
                'bind' => [
                    'email' => $email
                ]
            ], false
        );

        if(empty($user) || ! password_verify($password, $user['password'])) {
            return false;
        }

        $this->storeSession($user['nickname']);
        return true;
    }

    /**
     * Unsets current user session
     */
    public function logout() : void
    {
        if($this->isLogged()) {
            unset($_SESSION['nickname']);
        }
    }

    /**
     * Registers user to database, stores nickname in session on success
     *
     * @param string $email
     * @param string $nickname
     * @param string $password
     * @throws DuplicateEntryException : if email is already taken
     */
    public function register(string $email, string $nickname, string $password) : void
    {
        try {
            $this->insert(
                'users', [
                    'columns' => ['email', 'nickname', 'password'],
                    'bind' => [
                        'email' => $email,
                        'nickname' => $nickname,
                        'password' => password_hash($password, PASSWORD_DEFAULT)
                    ]
                ]
            );

            $this->storeSession($nickname);
        } catch (DuplicateEntryException $e) {
            throw new DuplicateEntryException();
        }
    }

    /**
     * Stores passed nickname inside session
     *
     * @param string $nickname
     */
    private function storeSession(string $nickname) : void
    {
        $_SESSION['nickname'] = $nickname;
    }

    /**
     * @return bool
     */
    public function isLogged() : bool
    {
        return isset($_SESSION['nickname']);
    }

    /**
     * Returns logged user's nickname
     *
     * @return string
     * @throws UserNotLoggedException
     */
    public function getNickname() : string
    {
        if(false === $this->isLogged()) {
            throw new UserNotLoggedException();
        }

        return $_SESSION['nickname'];
    }
}